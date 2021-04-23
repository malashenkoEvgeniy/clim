<?php

namespace App\Modules\Comments\Controllers\Admin;

use App\Core\AdminController;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Comments\Filters\CommentFilter;
use App\Modules\Comments\Forms\AdminCommentForm;
use App\Modules\Comments\Models\Comment;
use App\Modules\Comments\Requests\AdminCommentRequest;
use Seo, Route;

/**
 * Class CommentsController
 *
 * @package App\Modules\Comments\Controllers\Admin
 */
class CommentsController extends AdminController
{
    /**
     * @var string
     */
    protected $morphClassName;
    
    /**
     * CommentsController constructor.
     */
    public function __construct()
    {
        // Set main breadcrumbs for comments model with current type
        if (Route::current()) {
            // Get type
            $type = (string)Route::current()->parameter('type');
            // Get morph class by type
            $this->morphClassName = Comment::getActualClassNameForMorph($type);
            // Not registered type
            abort_if($this->morphClassName === $type && !Route::currentRouteNamed('admin.comments.active'), 404);
            Seo::breadcrumbs()->add(
                "comments::seo.$type.index",
                RouteObjectValue::make('admin.comments.index', ['type' => $type])
            );
        }
    }
    
    /**
     * Render comments list page
     *
     * @param string $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function index(string $type)
    {
        // Create new article button
        $this->addCreateButton('admin.comments.create', ['type' => $type]);
        // Set h1
        Seo::meta()->setH1("comments::seo.$type.index");
        // Get comments list
        $comments = Comment::getList($type);
        // Render template
        return view('comments::admin.index', [
            'comments' => $comments,
            'filter' => CommentFilter::showFilter(),
            'morphClass' => $this->morphClassName,
        ]);
    }
    
    /**
     * Create new comment page
     *
     * @param  string $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function create(string $type)
    {
        // Breadcrumb
        Seo::breadcrumbs()->add("comments::seo.$type.create");
        // Set h1
        Seo::meta()->setH1("comments::seo.$type.create");
        // Javascript validation
        $this->initValidation((new AdminCommentRequest())->rules());
        // Return form view
        return view('comments::admin.create', [
            'form' => AdminCommentForm::make(null, $this->morphClassName),
            'type' => $type,
        ]);
    }
    
    /**
     * Create comment in database
     *
     * @param  AdminCommentRequest $request
     * @param  string $type
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function store(AdminCommentRequest $request, string $type)
    {
        // Create new comment
        $comment = Comment::createAndLink($this->morphClassName, $request);
        // Do something
        return $this->afterStore(['id' => $comment->id, 'type' => $type]);
    }
    
    /**
     * Update comment page
     *
     * @param  Comment $comment
     * @param  string $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(string $type, Comment $comment)
    {
        // Breadcrumb
        Seo::breadcrumbs()->add("comments::seo.$type.edit");
        // Set h1
        Seo::meta()->setH1("comments::seo.$type.edit");
        // Javascript validation
        $this->initValidation((new AdminCommentRequest())->rules());
        // Return form view
        return view('comments::admin.update', [
            'form' => AdminCommentForm::make($comment, $this->morphClassName),
            'type' => $type,
        ]);
    }
    
    /**
     * Update comment in database
     *
     * @param  AdminCommentRequest $request
     * @param  Comment $comment
     * @param  string $type
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(AdminCommentRequest $request, string $type, Comment $comment)
    {
        // Fill new data
        $comment->updateComment($request);
        // Do something
        return $this->afterUpdate(['id' => $comment->id, 'type' => $type]);
    }
    
    /**
     * Totally delete comment from database
     *
     * @param  Comment $comment
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function destroy(string $type, Comment $comment)
    {
        // Delete review
        $comment->forceDelete();
        // Do something
        return $this->afterDestroy();
    }
    
}
