<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $request->user();

        return [
            'id' => $this->id,
            'user' => UserResource::make($this->whenLoaded('user')),
            'post' => PostResource::make($this->whenLoaded('post')),
            'body' => $this->body,
            'preview' => $this->preview_body(),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'can' => $this->when($user, [
                'update' => $user?->can('update', $this->resource),
                'destroy' => $user?->can('delete', $this->resource),
            ]),
        ];
    }
}
