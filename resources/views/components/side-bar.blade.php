<aside id="sidebar" class="js-sidebar">
    <!-- Content For Sidebar -->
    <div class="h-100">
        <div class="sidebar-logo">
            {{-- <a href="#">The eXlents Report</a> --}}
            <a href="#">Accounting Report</a>
            
        </div>
        
        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Admin
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link text">
                    <i class="fa-solid fa-chart-line pe-2"></i>
                    Dashboard
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{route('shop.store')}}" class="sidebar-link collapsed text"><i class="fa-solid fa-shop pe-2"></i>
                    Shop
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{route('departments.store')}}" class="sidebar-link collapsed text" >
                    <i class="fa-solid fa-list pe-2"></i>
                    Department 
                </a>
            </li>
            {{-- Sales Start --}}
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed text" data-bs-target="#auth" data-bs-toggle="collapse"
                    aria-expanded="false"><i class="fa-solid fa-cart-shopping pe-2"></i>
                    Sales
                </a>
                <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item ms-3">
                        <a href="{{route('sales.list')}}" class="sidebar-link collapsed text" >
                            <i class="fa-solid fa-sliders pe-2"></i>
                            Manage Sales 
                        </a>
                    </li>
                    <li class="sidebar-item ms-3">
                        <a href="{{route('paymentmethod.store')}}" class="sidebar-link collapsed text" >
                            <i class="fa-solid fa-sliders pe-2"></i>
                            Other Payment method 
                        </a>
                    </li>
                    <li class="sidebar-item ms-3">
                        <a href="{{route('shifts.index')}}" class="sidebar-link collapsed text" >
                            <i class="fa-solid fa-sliders pe-2"></i>
                            Sales
                        </a>
                    </li> 
                    <li class="sidebar-item ms-3">
                        <a href="{{route('bill_images.create')}}" class="sidebar-link collapsed text" >
                            <i class="fa-solid fa-sliders pe-2"></i>
                            Bill Images
                        </a>
                    </li> 
                    <li class="sidebar-item ms-3">
                        <a href="{{route('shiftNode.show')}}" class="sidebar-link collapsed text" >
                            <i class="fa-solid fa-sliders pe-2"></i>
                            Shift Notes
                        </a>
                    </li>                                               
                </ul>
            </li>
            {{-- Sales End --}}
            
            {{-- <li class="sidebar-item">
                <a href="{{route('paymentmethod.store')}}" class="sidebar-link collapsed" >
                    <i class="fa-solid fa-sliders pe-2"></i>
                    Payment method 
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{route('pettycashreason.store')}}" class="sidebar-link collapsed" >
                    <i class="fa-solid fa-sliders pe-2"></i>
                    Petty Cash Reason 
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{route('shifts.index')}}" class="sidebar-link collapsed" >
                    <i class="fa-solid fa-sliders pe-2"></i>
                    Sale 
                </a>
            </li> --}}
            

            {{-- Income Start --}}
            
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed text" data-bs-target="#income_details" data-bs-toggle="collapse"
                    aria-expanded="false"><i class="fa-solid fa-money-bill pe-2"></i>
                    Income
                </a>
                <ul id="income_details" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar"> 
                    <li class="sidebar-item ms-3">
                        <a href="{{route('income_category.store')}}" class="sidebar-link collapsed text" >
                            <i class="fa-solid fa-sliders pe-2"></i>
                            Income Category
                        </a>
                    </li>                           
                    <li class="sidebar-item ms-3">
                        <a href="{{route('other_income_departments.store')}}" class="sidebar-link collapsed text" >
                            <i class="fa-solid fa-sliders pe-2"></i>
                            Income Department 
                        </a>
                    </li>
                    <li class="sidebar-item ms-3">
                        <a href="{{route('paymenttype.store')}}" class="sidebar-link collapsed text" >
                            <i class="fa-solid fa-sliders pe-2"></i>
                            Payment type
                        </a>
                    </li> 
                    <li class="sidebar-item ms-3">
                        <a href="{{route('otherincome.store')}}" class="sidebar-link collapsed text" >
                            <i class="fa-solid fa-sliders pe-2"></i>
                            Income
                        </a>
                    </li>
                </ul>
            </li> 

            {{-- Income End --}}

            {{-- Expense Start --}}
            
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed text" data-bs-target="#ex_ca" data-bs-toggle="collapse"
                    aria-expanded="false"><i class="fa-solid fa-money-bill-transfer pe-2"></i>
                    Expenses
                </a>
                <ul id="ex_ca" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item ms-3">
                        <a href="{{route('expense_category.store')}}" class="sidebar-link collapsed text" >
                            <i class="fa-solid fa-sliders pe-2"></i>
                            Expense Category
                        </a>
                    </li>
                    <li class="sidebar-item ms-3">
                        <a href="{{route('expense_sub_category.store')}}" class="sidebar-link collapsed text" >
                            <i class="fa-solid fa-sliders pe-2"></i>
                            Expense Sub Category
                        </a>
                    </li>                     
                    <li class="sidebar-item ms-3">
                        <a href="{{route('pettycashreason.store')}}" class="sidebar-link collapsed text" >
                            <i class="fa-solid fa-sliders pe-2"></i>
                            Expense Reason 
                        </a>
                    </li>
                    <li class="sidebar-item ms-3">
                        <a href="{{route('paymenttype.store')}}" class="sidebar-link collapsed text" >
                            <i class="fa-solid fa-sliders pe-2"></i>
                            Payment type
                        </a>
                    </li>
                    <li class="sidebar-item ms-3">
                        <a href="{{route('otherexpense.store')}}" class="sidebar-link collapsed text" >
                            <i class="fa-solid fa-sliders pe-2"></i>
                            Other Expense
                        </a>
                    </li> 
                </ul>
            </li> 

            {{-- Expense End --}}

            {{-- <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed" data-bs-target="#auth" data-bs-toggle="collapse"
                    aria-expanded="false"><i class="fa-regular fa-user pe-2"></i>
                    Staff
                </a>
                <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="{{route('staff.addstaff')}}" class="sidebar-link">Dashboard</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Login</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Register</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Forgot Password</a>
                    </li>
                </ul>
            </li> --}}

            <li class="sidebar-item">
                <a href="{{route('staff.addstaff')}}" class="sidebar-link collapsed text" >
                    <i class="fa-solid fa-users pe-2"></i>
                    Staff  
                </a>
            </li>

            <li class="sidebar-item">
                <a href="#userList" class="sidebar-link collapsed text" data-bs-toggle="collapse" aria-expanded="false"><i
                        class="fa-regular fa-user pe-2"></i>
                    User
                </a>
                <ul id="userList" class="sidebar-dropdown list-unstyled collapse">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link text">Login</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link text">Register</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link text">Forgot Password</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a href="{{route('shiftstaff.search')}}" class="sidebar-link collapsed text" >
                    <i class="fa-solid fa-clock-rotate-left pe-2"></i>
                    ShiftEdit 
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{route( 'search.shiftsStaff')}}" class="sidebar-link collapsed text" >
                    <i class="fa-solid fa-clock-rotate-left pe-2"></i>
                    Serach shifts by Staffs
                </a>
            </li>

            <hr>
            
            {{-- <li class="sidebar-header">
                Calculations
            </li>
            <li>
                <a href="{{route('reports.form')}}" class="sidebar-link text">Cash Differ Report</a>
            </li>
            <li class="sidebar-item">
                <a href="{{route('reports.payment')}}" class="sidebar-link text">Payment method Report</a>
            </li>
            <li class="sidebar-item">
                <a href="{{route('reports.ownerexpense')}}" class="sidebar-link text">ownerexpenseReport</a>
            </li> --}}
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed text" data-bs-target="#multi" data-bs-toggle="collapse"
                    aria-expanded="false"><i class="fa-solid fa-file pe-2"></i>
                    Reports
                </a>
                <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item ms-3">
                        <a href="{{route('reports.form')}}" class="sidebar-link text">
                            <i class="fa-regular fa-file pe-2"></i>
                            Cash Differ Report
                        </a>
                    </li>
                    <li class="sidebar-item ms-3">
                        <a href="#" class="sidebar-link collapsed" data-bs-target="#level-2"
                            data-bs-toggle="collapse" aria-expanded="false">
                            <i class="fa-solid fa-file pe-2"></i>
                            Sales Report
                        </a>
                        <ul id="level-2" class="sidebar-dropdown list-unstyled collapse">
                            <li class="sidebar-item ms-3">
                                <a href="{{route('reports.payment')}}" class="sidebar-link text">
                                    <i class="fa-regular fa-file pe-2"></i>                                      
                                    Other Payment Method
                                </a>
                            </li>
                        </ul>

                    </li>
                    <li class="sidebar-item ms-3">

                        <a href="#" class="sidebar-link collapsed" data-bs-target="#level-1"
                            data-bs-toggle="collapse" aria-expanded="false">
                            <i class="fa-solid fa-file pe-2"></i>
                            Expense Report
                        </a>
                        <ul id="level-1" class="sidebar-dropdown list-unstyled collapse">
                            <li class="sidebar-item ms-3">
                                <a href="{{route('reports.ownerexpense')}}" class="sidebar-link text">
                                    <i class="fa-regular fa-file pe-2"></i>
                                    Payment Method
                                </a>
                            </li>
                            <li class="sidebar-item ms-3">
                                <a href="{{route('reports.expense')}}" class="sidebar-link text">
                                    <i class="fa-regular fa-file pe-2"></i>
                                    Expense Reason 
                                </a>
                            </li>
                            
                        </ul>
                    </li>
                    <li class="sidebar-item ms-3">
                        <a href="{{route('reports.cashMove')}}" class="sidebar-link text">
                            <i class="fa-regular fa-file pe-2"></i>
                            Cash Movement Report  
                        </a>
                    </li>
                    <li class="sidebar-item ms-3">
                        <a href="{{route('reports.IncomeExpo')}}" class="sidebar-link text">
                            <i class="fa-regular fa-file pe-2"></i>
                            Income And Expense Report 
                        </a>
                    </li>
                    {{-- <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" data-bs-target="#level-1"
                            data-bs-toggle="collapse" aria-expanded="false">Level 1</a>
                        <ul id="level-1" class="sidebar-dropdown list-unstyled collapse">
                            <li class="sidebar-item">
                                <a href="{{route('reports.form')}}" class="sidebar-link text">Cash Differ Report</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{route('reports.payment')}}" class="sidebar-link text">Payment method Report</a>
                            </li>
                        </ul>
                    </li> --}}
                </ul>
            </li>
        </ul>
    </div>
</aside>