<?php

namespace App\Modules\SeoFiles\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Storage;

/**
 * App\Modules\SeoFiles\Models\SeoFile
 *
 * @property int $id
 * @property string $name
 * @property string $ext
 * @property string $mime
 * @property string $size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $content
 * @property-read mixed $exists
 * @property-read mixed $file
 * @property-read mixed $path
 * @property-read mixed $url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoFiles\Models\SeoFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoFiles\Models\SeoFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoFiles\Models\SeoFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoFiles\Models\SeoFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoFiles\Models\SeoFile whereExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoFiles\Models\SeoFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoFiles\Models\SeoFile whereMime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoFiles\Models\SeoFile whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoFiles\Models\SeoFile whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoFiles\Models\SeoFile whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SeoFile extends Model
{
    const DISK = 'seo-file';
    
    protected $fillable = ['updated_at'];
    
    public static function getAll()
    {
        return SeoFile::oldest('name')->get();
    }
    
    /**
     * @param Request $request
     * @return int
     * @throws \Exception
     */
    public static function createFile(Request $request)
    {
        $name = Str::slug($request->input('name'));
        $ext = $request->input('type');
        $content = $request->input('content') ?? '';
        $filename = $name . $ext;
        if (!Storage::disk(SeoFile::DISK)->put($filename, $content)) {
            throw new \Exception(__('seo_files::general.can-not-create-file'));
        }
        $createdFile = new UploadedFile(Storage::disk(SeoFile::DISK)->path($filename), $filename);

        $file = new SeoFile();
        $file->name = $filename;
        $file->ext = trim($ext, '.');
        $file->mime = $createdFile->getMimeType();
        $file->size = $createdFile->getSize();
        if ($file->save()) {
            return $file->id;
        }
        Storage::disk(SeoFile::DISK)->delete(Storage::disk(SeoFile::DISK)->path($filename));
        throw new \Exception(__('seo_files::general.can-not-create-file-in-db'));
    }
    
    public function updateContent(Request $request)
    {
        try {
            if (!Storage::disk(SeoFile::DISK)->put($this->name, $request->input('content', ''))) {
                return __('seo_files::general.can-not-update-file');
            }
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
        $file = new UploadedFile($this->path, $this->name);
        $this->size = $file->getSize();
        $this->save();
        return true;
    }
    
    public function deleteFile()
    {
        if ($this->exists) {
            Storage::disk(SeoFile::DISK)->delete($this->name);
        }
        return $this->delete();
    }
    
    public function getContentAttribute(): string
    {
        if ($this->exists) {
            return file_get_contents($this->path);
        }
        return '';
    }
    
    public function getFileAttribute(): ?UploadedFile
    {
        if ($this->exists) {
            return new UploadedFile($this->path, $this->name);
        }
        return null;
    }
    
    public function getPathAttribute(): string
    {
        return Storage::disk(SeoFile::DISK)->path($this->name);
    }
    
    public function getExistsAttribute(): bool
    {
        return Storage::disk(SeoFile::DISK)->exists($this->name);
    }
    
    public function getUrlAttribute(): string
    {
        return Storage::disk(SeoFile::DISK)->url($this->name);
    }
    
}
