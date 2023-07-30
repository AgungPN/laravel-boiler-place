<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->builderMacros();
        $this->storageMacros();
    }

    public function builderMacros()
    {
        /**
         * where column contains value
         * alias from WHERE LIKE
         *
         * @param string|array $columns
         * @param string $value
         * @return Builder
         * @example $query->contains('column','value')
         * @example $query->contains(['column','column2'],'value')
         * @example $query->contains('relation.column','value')
         */
        Builder::macro('contains', function (string|array $columns, string $value): Builder {
            /** @var Builder $this */
            $this->where(function (Builder $query) use ($columns, $value) {
                foreach (Arr::wrap($columns) as $column) {
                    $query->when(
                        str_contains($column, '.'),

                        // Relational searches
                        function (Builder $query) use ($column, $value) {
                            $parts = explode('.', $column);
                            $relationColumn = array_pop($parts);
                            $relationName = join('.', $parts);

                            return $query->orWhereHas(
                                $relationName,
                                function (Builder $query) use ($relationColumn, $value) {
                                    $query->where($relationColumn, 'LIKE', "%{$value}%");
                                }
                            );
                        },

                        // Default searches
                        function (Builder $query) use ($column, $value) {
                            return $query->orWhere($column, 'LIKE', "%{$value}%");
                        }
                    );
                }
            });

            return $this;
        });
    }

    public function storageMacros()
    {
        Storage::macro('urlToStorage', function (string $url, string $path, ?string $fileName = null) {
            $contents = file_get_contents($url);
            $explodeUrl = explode('.', $url);
            $extension = strtolower(end($explodeUrl));
            $randomName = time() . uniqid() . '.' . $extension;

            $finalFileName = $fileName ?? $randomName;
            Storage::put($path . '/' . $finalFileName, $contents);
            return $finalFileName;
        });

        Storage::macro('replace', function (
            UploadedFile $request, string $path,
            ?string      $oldFile = null, ?string $newFileName = null
        ): string {
            if (!is_null($oldFile)) {
                Storage::delete($oldFile);
            }
            $randomName = time() . '.' . $request->getClientOriginalExtension();

            $finalFileName = $newFileName ?? $randomName;
            Storage::putFileAs($path, $request, $finalFileName);
            return $finalFileName;
        });
    }
}
