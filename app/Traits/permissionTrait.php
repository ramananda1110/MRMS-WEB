<?php
namespace App\Traits;

trait permissionTrait{
    public function hasPermission(){


         // for meeting
         if(!isset(auth()->user()->role->permission['name']['meeting']['can-add']) && \Route::is('meeting.create')){
            return abort(401);
        }

        if(!isset(auth()->user()->role->permission['name']['meeting']['can-list']) && \Route::is('meeting.index')){
            return abort(401);
        }

         // for employee
         if(!isset(auth()->user()->role->permission['name']['employee']['can-add']) && \Route::is('employee.create')){
            return abort(401);
        }

        if(!isset(auth()->user()->role->permission['name']['employee']['can-list']) && \Route::is('employee.index')){
            return abort(401);
        }


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


        // add permission for admin
        if(auth()->user()->isAdmin()){
            \Route::is('permissions.create');
        } else {
            // for permission
            if(!isset(auth()->user()->role->permission['name']['permission']['can-add']) && \Route::is('permissions.create')){
                return abort(401);
            }

            if(!isset(auth()->user()->role->permission['name']['permission']['can-list']) && \Route::is('permissions.index')){
                return abort(401);
            }
        }

        

         // for role
         if(!isset(auth()->user()->role->permission['name']['role']['can-add']) && \Route::is('roles.create')){
            return abort(401);
        }

        if(!isset(auth()->user()->role->permission['name']['role']['can-list']) && \Route::is('roles.index')){
            return abort(401);
        }


        // if(!isset(auth()->user()->role->permission['name']['leave']['can-add']) && \Route::is('leaves.create')){
        //     return abort(401);
        // }

        if(!isset(auth()->user()->role->permission['name']['leave']['can-list']) && \Route::is('leaves.index')){
            return abort(401);
        }


         // for notices
         if(!isset(auth()->user()->role->permission['name']['notice']['can-add']) && \Route::is('notices.create')){
            return abort(401);
        }

        if(!isset(auth()->user()->role->permission['name']['notice']['can-list']) && \Route::is('notices.index')){
            return abort(401);
        }


    }
}







