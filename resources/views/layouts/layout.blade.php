<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The eXlents Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/dashboard-style.css') }}">

    <style>
        /* Define the styles for the text */
        .text {
          font-size: 24px;
          color: #333; /* Default color */
          transition: color 0.3s; /* Smooth transition effect */
        }
        
        /* Define the hover effect */
        .text:hover {
          color: #ffd000; /* Color to change to on hover */
          cursor: pointer; /* Change cursor to pointer on hover */
        }
      </style>
    
</head>


<body>
    <div class="wrapper">
        <aside id="sidebar" class="js-sidebar">
            <!-- Content For Sidebar -->
            <div class="h-100">
                <div class="sidebar-logo">
                    <a href="#">The eXlents Report</a>
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
                                <a href="{{route('shifts.index')}}" class="sidebar-link collapsed text" >
                                    <i class="fa-solid fa-sliders pe-2"></i>
                                    Sales
                                </a>
                            </li>
                            <li class="sidebar-item ms-3">
                                <a href="{{route('paymentmethod.store')}}" class="sidebar-link collapsed text" >
                                    <i class="fa-solid fa-sliders pe-2"></i>
                                    Sales Payment method 
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
                                <a href="{{route('other_income_departments.store')}}" class="sidebar-link collapsed text" >
                                    <i class="fa-solid fa-sliders pe-2"></i>
                                    Income Department 
                                </a>
                            </li>
                            <li class="sidebar-item ms-3">
                                <a href="{{route('paymenttype.store')}}" class="sidebar-link collapsed text" >
                                    <i class="fa-solid fa-sliders pe-2"></i>
                                    Income Payment type
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
                                <a href="{{route('user.create')}}" class="sidebar-link text">Register</a>
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
                    
                    <li class="sidebar-header">
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
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed text" data-bs-target="#multi" data-bs-toggle="collapse"
                            aria-expanded="false"><i class="fa-solid fa-file pe-2"></i>
                            Reports
                        </a>
                        <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
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
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </aside>
        <div class="main">
            <nav class="navbar navbar-expand px-3 border-bottom">
                <button class="btn" id="sidebar-toggle" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse navbar">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                                <img src="{{ asset('image/profile.jpg') }}" class="avatar img-fluid rounded-circle" alt="">                                
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="{{route('user.profile')}}" class="dropdown-item">Profile</a>
                                <a href="#" class="dropdown-item">Setting</a>
                                <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item">Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="content px-3 py-2">

                {{-- Page contents goes here --}}

                @yield('content')

            </main>
            <a href="#" class="theme-toggle">
                <i class="fa-regular fa-moon"></i>
                <i class="fa-regular fa-sun"></i>
            </a>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a href="#" class="text-muted">
                                    <strong>The eXlents Report</strong>
                                </a>
                            </p>
                        </div>
                        <div class="col-6 text-end">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="#" class="text-muted">Contact</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="text-muted">About Us</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="text-muted">Terms</a>
                                </li>                                
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/dashboard-script.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>