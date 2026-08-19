<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'short_description',
        'content',
        'featured_image',
        'author',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'tags',
        'status',
        'is_featured',
        'published_at',
    ];

    /**
     * Get tags as array.
     */
    public function getTagsArrayAttribute(): array
    {
        if (empty($this->tags)) {
            return [];
        }
        return array_map('trim', explode(',', $this->tags));
    }

    /**
     * Get the category that owns the blog post.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_featured' => 'boolean',
        ];
    }

    /**
     * Scope for featured blogs.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get featured image URL attribute.
     */
    public function getFeaturedImageUrlAttribute(): ?string
    {
        if ($this->featured_image && Storage::disk('public')->exists($this->featured_image)) {
            return Storage::disk('public')->url($this->featured_image);
        }

        return null;
    }

    /**
     * Get live public URL for the blog post on main website.
     */
    public function getLiveUrlAttribute(): string
    {
        $baseUrl = rtrim(config('app.main_site_url', env('MAIN_SITE_URL', 'http://localhost/webwiders/')), '/');
        return $baseUrl . '/blog-detail/' . $this->slug;
    }


    /**
     * Scope for published blogs.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->where(function ($q) {
                         $q->whereNull('published_at')
                           ->orWhere('published_at', '<=', now());
                     });
    }

    /**
     * Scope for draft blogs.
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope for searching blogs by title or description.
     */
    public function scopeSearch($query, $search)
    {
        if (!empty($search)) {
            return $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }
        return $query;
    }

    /**
     * Scope for filtering blogs by category.
     */
    public function scopeCategory($query, $categoryIdOrSlug)
    {
        if (!empty($categoryIdOrSlug)) {
            if (is_numeric($categoryIdOrSlug)) {
                return $query->where('category_id', $categoryIdOrSlug);
            }
            return $query->whereHas('category', function ($q) use ($categoryIdOrSlug) {
                $q->where('slug', $categoryIdOrSlug);
            });
        }
        return $query;
    }
}
