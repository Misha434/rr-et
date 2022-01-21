<?php

Breadcrumbs::for('カテゴリー一覧', function ($trail)
{
  $trail->push('カテゴリー一覧', route('categories.index'));
});

Breadcrumbs::for('ネタ一覧', function ($trail)
{
  $trail->parent('カテゴリー一覧');
  $trail->push('ネタ一覧', route('scripts.index'));
});

Breadcrumbs::for('カテゴリー', function ($trail, $category)
{
  $trail->parent('カテゴリー一覧');
  $trail->push($category, route('categories.show', compact('category')));
});