@inject('controller', 'App\Http\Controllers\BaseController')

<div class="fixed-sidebar-left">
    <ul class="nav navbar-nav side-nav nicescroll-bar">
        @foreach ($init['parent_menus'] as $parent_menu)
            <li class="navigation-header">
                <span>{{ $parent_menu->MENU_NAME }}</span> 
                <i class="zmdi zmdi-more"></i>
            </li>
            @foreach ($init['child_menus'] as $child_menu)
                @if ($child_menu->PARENT_ID == $parent_menu->MENU_ID)
                    <li>
                        <a class="{{ $controller::checkActiveSubMenu(Request::segment(1), $child_menu->MENU_URL) }}"
                                href="{{ route($child_menu->MENU_URL) }}">
                                <div class="pull-left">
                                    <i class="{{ $child_menu->MENU_ICON }} mr-10"></i>
                                    <span class="right-nav-text">{{ $child_menu->MENU_NAME }}</span>
                                </div>
                                <div class="clearfix"></div>
                        </a>
                    </li> 
                @endif
            @endforeach

            @if(!$loop->last)
                <li><hr class="light-grey-hr mb-10"/></li>
            @endif

            <!-- @foreach ($init['parent_menus'] as $parent_menu)
            <li>
                <a class="{{ $controller::checkActiveParentMenu(Request::segment(1), $parent_menu->MENU_ID) }}"
                    href="{{ $controller::checkParent($parent_menu->MENU_ID) ? 'javascript: return false;' : route($parent_menu->MENU_URL) }}"
                    data-toggle="collapse" data-target="#form_dr{{ $parent_menu->MENU_ID }}">
                    <div class="pull-left">
                        <i class="{{ $parent_menu->MENU_ICON }} mr-10"></i>
                        <span class="right-nav-text">{{ $parent_menu->MENU_NAME }}</span>
                    </div>
                    @if ($controller::checkParent($parent_menu->MENU_ID))
                        <div class="pull-right">
                            <i class="zmdi zmdi-caret-down"></i>
                        </div>
                    @endif
                    <div class="clearfix"></div>
                </a>
                <ul id="form_dr{{ $parent_menu->MENU_ID }}" class="collapse collapse-level-1 two-col-list">
                    @foreach ($init['child_menus'] as $child_menu)
                        @if ($child_menu->PARENT_ID == $parent_menu->MENU_ID)
                            <li>
                                <a class="{{ $controller::checkActiveSubMenu(Request::segment(1), $child_menu->MENU_URL) }}"
                                    href="{{ route($child_menu->MENU_URL) }}">{{ $child_menu->MENU_NAME }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
        @endforeach -->
            
        @endforeach
    </ul>
</div>