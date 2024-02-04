<?php
namespace App\Traits;

trait permissionTrait{
    public function hasPermission(){

        // for department
        if(!isset(auth()->user()->role->permission['name']['department']['can-add']) && \Route::is('departments.create')){
            return abort(401);
        }

        if(!isset(auth()->user()->role->permission['name']['department']['can-list']) && \Route::is('departments.index')){
            return abort(401);
        }

         // for user
         if(!isset(auth()->user()->role->permission['name']['user']['can-add']) && \Route::is('users.create')){
            return abort(401);
        }

        if(!isset(auth()->user()->role->permission['name']['user']['can-list']) && \Route::is('users.index')){
            return abort(401);
        }

         // for permission
         if(!isset(auth()->user()->role->permission['name']['permission']['can-add']) && \Route::is('permissions.create')){
            return abort(401);
        }

        if(!isset(auth()->user()->role->permission['name']['permission']['can-list']) && \Route::is('permissions.index')){
            return abort(401);
        }

         // for role
         if(!isset(auth()->user()->role->permission['name']['role']['can-add']) && \Route::is('roles.create')){
            return abort(401);
        }

        if(!isset(auth()->user()->role->permission['name']['role']['can-list']) && \Route::is('roles.index')){
            return abort(401);
        }


        if(!isset(auth()->user()->role->permission['name']['leave']['can-add']) && \Route::is('leaves.create')){
            return abort(401);
        }

        if(!isset(auth()->user()->role->permission['name']['leave']['can-list']) && \Route::is('leaves.index')){
            return abort(401);
        }
    }
}







