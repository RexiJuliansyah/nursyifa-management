<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use App\Models\Menu;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->role_id = Auth::user()->ROLE_ID;

            $parent_menus = Menu::query()
                ->join('tb_m_permission', 'tb_m_menu.MENU_ID', '=', 'tb_m_permission.MENU_ID')
                ->where('tb_m_menu.PARENT_ID', 0)
                ->where('tb_m_permission.ROLE_ID', $this->role_id)
                ->orderBy('SEQUENCE')
                ->get();


            $child_menus = Menu::query()
                ->join('tb_m_permission', 'tb_m_menu.MENU_ID', '=', 'tb_m_permission.MENU_ID')
                ->where('tb_m_menu.PARENT_ID', '!=', 0)
                ->where('tb_m_permission.ROLE_ID', $this->role_id)
                ->orderBy('SEQUENCE')
                ->get();
            $user = Auth::user();
            $init = compact('parent_menus', 'child_menus', 'user');

            View::share('init', $init);

            return $next($request);
        });
    }

    public function getSystemVal($SYSTEM_TYPE, $SYSTEM_CD)
    {
        $system_val = System::where(['SYSTEM_TYPE' => $SYSTEM_TYPE, 'SYSTEM_CD' => $SYSTEM_CD])->first();

        return $system_val->SYSTEM_VAL;
    }

    public static function checkParent($PARENT_ID)
    {
        $menus = Menu::where('PARENT_ID', $PARENT_ID)->get();

        if ($menus->isNotEmpty()) {
            return true;
        } else {
            return false;
        }
    }

    public static function checkActiveParentMenu($MENU_URL, $PARENT_ID)
    {
        $menus = Menu::where('PARENT_ID', $PARENT_ID)->get();

        if ($menus->isNotEmpty()) {
            $column = 'PARENT_ID';
        } else {
            $column = 'MENU_ID';
        }

        $parent_menu = Menu::where($column, $PARENT_ID)->where('MENU_URL', strtok($MENU_URL, '-'))->get();
        if ($parent_menu->isNotEmpty()) {
            return 'active';
        } else {
            return '';
        }
    }

    public static function checkActiveSubMenu($CURRENT_URL, $MENU_URL)
    {
        $CURRENT_URL = str_replace("-", ".", $CURRENT_URL);
        $menu = Menu::where('MENU_URL', $MENU_URL)->where('MENU_URL', $CURRENT_URL)->get();

        if ($menu->isNotEmpty()) {
            return 'active-page';
        } else {
            $exist_menu = Menu::where('MENU_URL', $CURRENT_URL)->get();
            if ($exist_menu->isNotEmpty()) {
                return '';
            } else {
                $menus = Menu::where('MENU_URL', $MENU_URL)->where('MENU_URL', strtok($CURRENT_URL, '.'))->get();
                if ($menus->isNotEmpty()) {
                    return 'active-page';
                } else {
                    return '';
                }
            }
        }
    }

    public function checkPermission($ROLE_ID, $MENU_ID) {
        $permission = Permission::where(['ROLE_ID' => $ROLE_ID, 'MENU_ID' => $MENU_ID])->get();

        if ($permission->isEmpty()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
