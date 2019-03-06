<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

use Encore\Admin\Facades\Admin;

Encore\Admin\Form::forget(['map', 'editor']);
\Encore\Admin\Facades\Admin::js('js/table.js');

//if (Admin::user()->isAdministrator()) {
//
//}
//Admin::navbar(function (\Encore\Admin\Widgets\Navbar $navbar) {
//
//    $navbar->right(new \App\Admin\Extensions\Nav\Links());
//
//});