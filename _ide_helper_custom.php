<?php

namespace Illuminate\Database\Query {
    class Builder
    {
        /**
         * where column contains value
         * alias from "AND WHERE LIKE '%value%'
         *
         * @param string|array $columns
         * @param string $value
         * @return Builder
         * @example $query->contains('column','value')
         * @example $query->contains(['column','column2'],'value')
         * @example $query->contains('relation.column','value')
         */
        public function contains(string|array $columns, string $value): Builder
        {
            return $this;
        }
    }
}


namespace Illuminate\Support\Facades {
    class Storage
    {
        public function urlToStorage(string $url, string $path, ?string $fileName = null)
        {

        }

        public function replace(
            string  $requestName, string $path,
            ?string $oldPath = null, ?string $newFileName = null
        ): string
        {
            return '';
        }
    }
}
