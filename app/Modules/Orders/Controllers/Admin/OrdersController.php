<?php

namespace App\Modules\Orders\Controllers\Admin;

use App\Components\Delivery\NovaPoshta;
use App\Core\AjaxTrait;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Orders\Filters\OrdersFilter;
use App\Modules\Orders\Forms\OrderForm;
use App\Modules\Orders\Forms\OrderItemForm;
use App\Modules\Orders\Models\Order;
use App\Modules\Orders\Models\OrderClient;
use App\Modules\Orders\Models\OrderItem;
use App\Modules\Orders\Models\OrderStatusesHistory;
use App\Modules\Orders\Requests\ChangeOrderStatusRequest;
use App\Modules\Orders\Requests\GenerateTtnRequest;
use App\Modules\Orders\Requests\OrderAdminRequest;
use App\Modules\Orders\Requests\OrderItemRequest;
use App\Modules\Orders\Requests\UpdateOrderItemRequest;
use App\Modules\Orders\Types\OrderType;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;
use NovaPoshta\ApiModels\Address;
use NovaPoshta\ApiModels\Counterparty;
use NovaPoshta\ApiModels\InternetDocument;
use NovaPoshta\Config;
use NovaPoshta\MethodParameters\Address_getWarehouses;
use NovaPoshta\MethodParameters\Counterparty_cloneLoyaltyCounterpartySender;
use NovaPoshta\MethodParameters\Counterparty_getCounterpartyContactPersons;
use NovaPoshta\MethodParameters\InternetDocument_printDocument;
use NovaPoshta\Models\CounterpartyContact;
use Seo;
use App\Core\AdminController;

/**
 * Class OrdersController
 *
 * @package App\Modules\Orders\Controllers\Admin
 */
class OrdersController extends AdminController
{
    use AjaxTrait;

    public function __construct()
    {
        Seo::breadcrumbs()->add(
            'orders::seo.orders.index',
            RouteObjectValue::make('admin.orders.index')
        );
    }

    /**
     * Register widgets with buttons
     */
    private function registerButtons()
    {
        $this->addListButton('admin.orders.index');
        $this->addDeletedListButton('admin.orders.deleted');
        $this->addCreateButton('admin.orders.create');
    }

    /**
     * Pages sortable list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->registerButtons();
        Seo::meta()->setH1('orders::seo.orders.index');
        $orders = Order::paginatedList();
        return view('orders::admin.orders.index', [
            'orders' => $orders,
            'filter' => OrdersFilter::showFilter(),
        ]);
    }

    /**
     * Deleted orders list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deleted()
    {
        Seo::meta()->setH1('orders::seo.deleted');
        Seo::breadcrumbs()->add('orders::seo.deleted', RouteObjectValue::make('admin.orders.deleted'));
        $this->registerButtons();
        return view('orders::admin.orders.index', [
            'orders' => Order::paginatedListFromTheTrash(),
            'filter' => OrdersFilter::showFilter(),
        ]);
    }

    /**
     * Create new order page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function create()
    {
        Seo::breadcrumbs()->add('orders::seo.orders.create');
        Seo::meta()->setH1('orders::seo.orders.create');
        $this->jsValidation(new OrderAdminRequest);
        return view('orders::admin.orders.create', [
            'form' => OrderForm::make(),
        ]);
    }

    /**
     * Store to database
     *
     * @param  OrderAdminRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function store(OrderAdminRequest $request)
    {
        $dataToUpdate = $request->only(
            'user_id', 'delivery', 'payment_method', 'comment', 'do_not_call_me', 'paid', 'ttn'
        );
        $dataToUpdate['city_ref'] = $request->input('locationId');
        if ($request->input('delivery') === 'nova-poshta-self') {
            $warehouseRef = $request->input($request->input('delivery'));
            $dataToUpdate['warehouse_ref'] = $warehouseRef;
            $dataToUpdate['delivery_address'] = (new NovaPoshta)->getWarehouseInfo($warehouseRef);
        } else {
            $dataToUpdate['delivery_address'] = $request->input($request->input('delivery'));
        }
        $order = Order::store($dataToUpdate);
        $client = OrderClient::store(
            $order->id,
            $request->input('name'),
            $request->input('phone'),
            $request->input('email')
        );
        $order->updateItems(request()->input('items', []));
        OrderStatusesHistory::write($order->id, $order->status_id);
        event('orders::created', new OrderType($order, $client, new Collection()));
        return $this->afterStore(['id' => $order->id]);
    }

    /**
     * Update order page
     *
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(Order $order)
    {
        Seo::breadcrumbs()->add(
            trans('orders::seo.orders.show', ['id' => $order->id]),
            RouteObjectValue::make('admin.orders.show', [$order->id])
        );
        Seo::breadcrumbs()->add($order->current->name ?? 'orders::seo.orders.edit');
        Seo::meta()->setH1('orders::seo.orders.edit');
        $this->jsValidation(new OrderAdminRequest);
        return view('orders::admin.orders.update', [
            'form' => OrderForm::make($order),
            'order' => $order,
        ]);
    }

    /**
     * Update element in database
     *
     * @param  OrderAdminRequest $request
     * @param  Order $order
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(OrderAdminRequest $request, Order $order)
    {
        $dataToUpdate = $request->only(
            'delivery', 'payment_method', 'comment', 'do_not_call_me', 'paid', 'ttn'
        );
        $dataToUpdate['city_ref'] = $request->input('locationId');
        if ($request->input('delivery') === 'nova-poshta-self') {
            $warehouseRef = $request->input($request->input('delivery'));
            $dataToUpdate['warehouse_ref'] = $warehouseRef;
            $dataToUpdate['delivery_address'] = (new NovaPoshta)->getWarehouseInfo($warehouseRef);
        } else {
            $dataToUpdate['delivery_address'] = $request->input($request->input('delivery'));
        }
        $order->update($dataToUpdate);
        $order->client->update($request->only('name', 'email', 'phone'));
        $order->updateItems(request()->input('items', []));
        return $this->afterUpdate();
    }

    /**
     * Totally delete element from database
     *
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException|\Exception
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return $this->afterDestroy(null, route('admin.orders.index'));
    }

    /**
     * Restore deleted order
     *
     * @param int $orderId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function restore(int $orderId)
    {
        // Get trashed user
        $order = Order::withTrashed()->find($orderId);
        // Restore
        $order->restore();
        // Do something
        return $this->afterRestore();
    }

    /**
     * Show order page
     *
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Order $order)
    {
        $order->loadMissing('client', 'status', 'items');
        $title = trans('orders::seo.orders.show', ['id' => $order->id]);
        Seo::breadcrumbs()->add($title);
        Seo::meta()->setH1($title);
        $this->initValidation((new ChangeOrderStatusRequest)->rules(), '#change-order-status');
        $this->initValidation((new GenerateTtnRequest)->rules(), '#generate-ttn');
        return view('orders::admin.orders.show', [
            'order' => $order,
        ]);
    }

    /**
     * Show order page
     *
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function print(Order $order)
    {
        abort_unless($order->items && $order->items->isNotEmpty(), 404);
        $order->loadMissing('client', 'status', 'items');
        return view('orders::admin.orders.print', [
            'order' => $order,
        ]);
    }

    /**
     * @param ChangeOrderStatusRequest $request
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function status(ChangeOrderStatusRequest $request, Order $order)
    {
        if ($order->status_id === (int)$request->input('status_id')) {
            if ($request->expectsJson()) {
                return $this->errorJsonAnswer();
            }
            return redirect()->back();
        }
        $order->changeStatus((int)$request->input('status_id'), $request->input('comment'));
        if ($request->expectsJson()) {
            $status = $order->status->fresh();
            return $this->successJsonAnswer([
                'insertStatus' => view('orders::admin.orders.show-order-parts.status-history', [
                    'order' => $order,
                ])->render(),
                'status' => [
                    'name' => $status->current->name,
                    'color' => $status->color,
                ],
            ]);
        }
        return redirect()->back();
    }

    /**
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\WrongParametersException
     * @throws \Throwable
     */
    public function addItem(Order $order)
    {
        $formId = uniqid('add-item');
        return $this->successMfpMessage(view('orders::admin.orders.items.popup', [
            'title' => trans('orders::general.add-order-item-title'),
            'form' => OrderItemForm::make(),
            'validation' => $this->makeValidationJavaScript(
                (new OrderItemRequest())->rules(),
                '#' . $formId
            ),
            'formId' => $formId,
            'url' => route('admin.orders.add-item', $order->id),
        ])->render());
    }

    /**
     * @param OrderItemRequest $request
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function storeItem(OrderItemRequest $request, Order $order)
    {
        OrderItem::addByAdministrator($order->id, $request);
        if ($request->expectsJson()) {
            return $this->successJsonAnswer([
                'insert' => view('orders::admin.orders.show-order-parts.invoice-items', [
                    'order' => $order,
                ])->render(),
                'mfpClose' => true,
            ]);
        }
        return redirect()->route('admin.orders.show', $order->id);
    }

    /**
     * @param UpdateOrderItemRequest $request
     * @param OrderItem $item
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function updateItem(UpdateOrderItemRequest $request, OrderItem $item)
    {
        $config = config('db.products_dictionary.site_status', 0);
        if($config) {
            $check = OrderItem::whereProductId($item->product_id)->whereDictionaryId($request->input('dictionary'))->whereNotIn('id', [$item->id])->first();
            if (isset($check)){
                $check->quantity += $request->input('quantity');
                $check->save();
                $item->delete();
            } else {
                $item->updateQuantity($request->input('quantity'), $item->id);
                $item->updateDictionary($request->input('dictionary'), $item->id);
            }
        } else {
            $item->updateQuantity($request->input('quantity'), $item->id);
        }
        $order = $item->order;
        if ($request->expectsJson()) {
            return $this->successJsonAnswer([
                'insert' => view('orders::admin.orders.show-order-parts.invoice-items', [
                    'order' => $order->fresh('items'),
                ])->render(),
            ]);
        }
        return redirect()->route('admin.orders.show', $item->order_id);
    }

    /**
     * @param OrderItem $item
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function removeItem(OrderItem $item)
    {
        $order = $item->order;
        $itemsCount = $order->items->count();
        $item->delete();
        if (request()->expectsJson()) {
            if ($itemsCount - 1 === 0) {
                $template = 'no-items';
            } else {
                $template = 'invoice-items';
            }
            return $this->successJsonAnswer([
                'insert' => view('orders::admin.orders.show-order-parts.' . $template, [
                    'order' => $order->fresh('items'),
                ])->render(),
            ]);
        }
        return redirect()->back();
    }
    
    /**
     * @param GenerateTtnRequest $request
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function createEN(GenerateTtnRequest $request, Order $order)
    {
        if (!config('db.nova-poshta.key')) {
            return $this->errorJsonAnswer([
                'text' => [
                    'title' => 'Ошибка',
                    'content' => 'Пожалуйста, укажите АПИ ключ НП в настройках сайта!',
                ],
            ]);
        }
        
        Config::setApiKey(config('db.nova-poshta.key'));
        Config::setLanguage(Config::LANGUAGE_RU);
        // Создаем контрагента получателя
        $counterparty = new Counterparty();
        $counterparty->setCounterpartyProperty(Counterparty::RECIPIENT);
        $counterparty->setCityRef($request->recipientCity);
        $counterparty->setCounterpartyType('PrivatePerson');
        $counterparty->setFirstName($request->recipientLastName);
        $counterparty->setLastName($request->recipientFirsName);
        $counterparty->setMiddleName($request->recipientMiddleLame);
        $counterparty->setPhone($request->recipientPhone);
        $result = $counterparty->save();
        
        if (!$result || !$result->success) {
            return $this->errorJsonAnswer([
                'text' => [
                    'title' => 'Ошибка',
                    'content' => (count($result->errors)) ? array_first($result->errors) : 'Сервис НП не смог обработать заказ. Повторите попытку позднее',
                ],
            ]);
        }
        
        $counterpartyRecipient = $result->data[0]->Ref;

        // Теперь получим контрагента отправителя
        $data = new Counterparty_cloneLoyaltyCounterpartySender();
        $data->setCityRef($request->senderCity);
        $result = Counterparty::cloneLoyaltyCounterpartySender($data);
        $counterpartySender = $result->data[0]->Ref;

        // Получим контактных персон для контрагентов
        $data = new Counterparty_getCounterpartyContactPersons();
        $data->setRef($counterpartySender);
        $result = Counterparty::getCounterpartyContactPersons($data);
        $contactPersonSender = $result->data[0]->Ref;
        $data = new Counterparty_getCounterpartyContactPersons();
        $data->setRef($counterpartyRecipient);
        $result = Counterparty::getCounterpartyContactPersons($data);
        $contactPersonRecipient = $result->data[0]->Ref;
        // Для контрагента отправителя получим склад отправки
        $data = new Address_getWarehouses();
        $data->setCityRef($request->senderCity);
        $result = Address::getWarehouses($data);
        $addressSender = $result->data[5]->Ref;

        // Контрагент отправитель
        $sender = new CounterpartyContact();
        $sender->setCity($request->senderCity)
            ->setRef($counterpartySender)
            ->setAddress($addressSender)
            ->setContact($contactPersonSender)
            ->setPhone($request->senderPhone);
        // Контрагент получатель
        $recipient = new CounterpartyContact();
        $recipient->setCity($request->recipientCity)
            ->setRef($counterpartyRecipient)
            ->setAddress($request->recipientWarehouses)
            ->setContact($contactPersonRecipient)
            ->setPhone($request->recipientPhone);
        // Выбираем тип
        $internetDocument = new InternetDocument();
        $internetDocument->setSender($sender)
            ->setRecipient($recipient)
            ->setServiceType($request->serviceType)
            ->setPayerType($request->payerType)
            ->setPaymentMethod($request->paymentMethod)
            ->setCargoType($request->delivery)
            ->setWeight($request->weight)
            ->setSeatsAmount($request->volumeGeneral)
            ->setCost($request->cost)
            ->setDescription($request->description)
            ->setDateTime(Carbon::parse($request->preferredDeliveryDate)->format('d.m.Y'));
        $result = $internetDocument->save();

        if ($result->success == true) {
            $order->ttn = $result->data[0]->IntDocNumber;
            $order->ttn_ref = $result->data[0]->Ref;
            $order->save();
            
            return $this->successJsonAnswer([
                'reload' => true,
            ]);
        }
        
        return $this->errorJsonAnswer([
            'notyMessage' => count($result->errors) ? array_first($result->errors) : 'Произошла ошибка генерации ТТН',
        ]);
    }

    /**
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generateLinkForEn(Order $order)
    {
        $data = new InternetDocument_printDocument();
        $data->addDocumentRef($order->ttn_ref);
        $data->setCopies(InternetDocument::PRINT_COPIES_FOURFOLD);
        $link = InternetDocument::printDocument($data);

        return Redirect::away($link);
    }
    
    /**
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function documentsTracking(Order $order)
    {
        $delivery = new NovaPoshta();
        $response = $delivery->getDeliveryInformationByTTN($order->ttn);
        return $this->successJsonAnswer([
            'text' => [
                'icon' => 'fa fa-fw fa-truck',
                'title' => trans('orders::general.delivery-status'),
                'content' => $response->data[0]->Status,
            ],
        ]);
        
    }
    
    /**
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteTTN(Order $order)
    {
        Config::setApiKey(config('db.nova-poshta.key'));
        $internetDocument = new InternetDocument();
        $internetDocument->setRef($order->ttn_ref);
        $response = $internetDocument->delete();
        if ($response->success !== true) {
            return $this->errorJsonAnswer([
                'text' => [
                    'title' => 'Ошибка',
                    'content' => 'Сервис НП не смог отменить заказ. Пожалуйста, проверьте настройки ключа НП!',
                ],
            ]);
        }
        $order->ttn = '';
        $order->ttn_ref = '';
        $order->save();
        return $this->successJsonAnswer(['reload' => true]);
    }
}
