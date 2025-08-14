<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('dt.jpg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Logistics</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">


        <!-- SidebarSearch Form -->
        <div class="form-inline mt-3">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>

                </li>

                {{-- User Profle --}}

                <li class="nav-item has-treeview
                {{ request()->routeIs('user.profile.index') || request()->routeIs('user.change_password_form') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('user.profile.index') || request()->routeIs('user.change_password_form') ? 'active' : '' }}">
                        <i class="nav-icon fas fa fa-users"></i>
                        <p>
                             Profile Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.profile.index') }}"
                                class="nav-link {{ request()->routeIs('user.profile.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Profile Update</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.change_password_form') }}"
                                class="nav-link {{ request()->routeIs('user.change_password_form') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Change Password</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item has-treeview {{ request()->routeIs('customers.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Customer
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('customers.index') }}"
                                class="nav-link {{ request()->routeIs('customers.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Customer</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('customers.create') }}"
                                class="nav-link {{ request()->routeIs('customers.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Customer</p>
                            </a>
                        </li>
                    </ul>
                </li>


                {{-- Start Broker --}}

                <li class="nav-item has-treeview {{ request()->routeIs('brokers.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('brokers.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Brokers
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('brokers.index') }}"
                                class="nav-link {{ request()->routeIs('brokers.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Broker</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('brokers.create') }}"
                                class="nav-link {{ request()->routeIs('brokers.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Broker</p>
                            </a>
                        </li>
                    </ul>
                </li>



                {{-- Border END  --}}

                {{-- start user --}}

                <li class="nav-item has-treeview {{ request()->routeIs('contacts.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('contacts.*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-user-plus"></i>
                        <p>
                            Users
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('contacts.index') }}"
                                class="nav-link {{ request()->routeIs('contacts.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('contacts.create') }}"
                                class="nav-link {{ request()->routeIs('contacts.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Sender/Recepient</p>
                            </a>
                        </li>


                    </ul>
                </li>



                {{-- end users --}}





                {{-- Start Shipments --}}


                <li class="nav-item has-treeview {{ request()->routeIs('shippings.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('shippings.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa fa-truck"></i>
                        <p>
                            Shipping Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('shippings.index') }}"
                                class="nav-link {{ request()->routeIs('shippings.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Shipments</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('shippings.create') }}"
                                class="nav-link {{ request()->routeIs('shippings.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Job</p>
                            </a>
                        </li>
                    </ul>
                </li>

                </li>




                {{-- Shipments END  --}}


                {{-- Expences --}}

                <li
                    class="nav-item has-treeview {{ request()->routeIs('gatepasses.*') || request()->routeIs('clearingagents.*') || request()->routeIs('lifterCharges.*')  || request()->routeIs('labourCharges.*') || request()->routeIs('localCharges.*') || request()->routeIs('otherCharges.*') || request()->routeIs('partyCommissionCharges.*') || request()->routeIs('trackerCharges.*') || request()->routeIs('fuels.*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('gatepasses.*') || request()->routeIs('clearingagents.*') || request()->routeIs('lifterCharges.*')  || request()->routeIs('labourCharges.*') || request()->routeIs('localCharges.*') || request()->routeIs('otherCharges.*') || request()->routeIs('partyCommissionCharges.*') || request()->routeIs('trackerCharges.*') || request()->routeIs('fuels.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-coins"></i>
                        <p>
                            Expenses Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('gatepasses.index') }}"
                                class="nav-link {{ request()->routeIs('gatepasses.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Gate Pass</p>
                            </a>
                        </li>

                         <li class="nav-item">
                            <a href="{{ route('fuels.index') }}"
                                class="nav-link {{ request()->routeIs('fuels.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Fuels
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('clearingagents.index') }}"
                                class="nav-link {{ request()->routeIs('clearingagents.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Clearing Agents </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('lifterCharges.index') }}"
                                class="nav-link {{ request()->routeIs('lifterCharges.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Lifter Charges </p>
                            </a>
                        </li>



                        <li class="nav-item">
                            <a href="{{ route('labourCharges.index') }}"
                                class="nav-link {{ request()->routeIs('labourCharges.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Labour Charges </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('localCharges.index') }}"
                                class="nav-link {{ request()->routeIs('localCharges.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Local Charges </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('otherCharges.index') }}"
                                class="nav-link {{ request()->routeIs('otherCharges.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Other Charges </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('partyCommissionCharges.index') }}"
                                class="nav-link {{ request()->routeIs('partyCommissionCharges.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Party Commission </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('trackerCharges.index') }}"
                                class="nav-link {{ request()->routeIs('trackerCharges.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Tracker Charges </p>
                            </a>
                        </li>


                    </ul>
                </li>



                {{-- Expences END  --}}

                {{-- Accounts Modules --}}

                <li class="nav-item has-treeview {{ request()->routeIs('ledger.*') || request()->routeIs('accounts.*') ? 'menu-open' : '' }} ">
                    <a href="#" class="nav-link {{ request()->routeIs('ledger.*') || request()->routeIs('accounts.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Accounts
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                        <a href="{{ route('ledger.index', ['ledgerType' => 'payable']) }}"
                            class="nav-link {{ request('ledgerType') == 'payable' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Payables</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('ledger.index' , ['ledgerType' => 'receivable']) }}"
                                class="nav-link {{ request('ledgerType') == 'receivable' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Receivables</p>
                            </a>
                        </li>

                         <li class="nav-item">
                            <a href="{{ route('accounts.index') }}"
                                class="nav-link {{ request()->routeIs('accounts.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Payment Accounts</p>
                            </a>
                        </li>


                    </ul>
                </li>

                {{-- Accounts Modules --}}

                {{-- Logout --}}
                <li class="nav-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <a href="#" class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Logout</p>
                    </a>
                </li>




            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
