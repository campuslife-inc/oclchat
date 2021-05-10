
<ul class="menu-nav side-menu py-0">   
    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
        <a href="javascript:;" class="menu-link d-flex align-items-center menu-toggle">
            <span class="svg-icon menu-icon">
                  <img class="" src="{{URL::to('/')}}/app-assets/images/icons/dashboard.png" alt=""
               class="img-fluid">
            </span>
            <span class="menu-text">Dashboard</span>
            <i class="menu-arrow"></i>
        </a>

        <div class="menu-submenu">
            <i class="menu-arrow"></i>
            <ul class="menu-subnav">
                 <li class="menu-item" aria-haspopup="true">
                    <a  target="" href="{{ url('/') }}/dashboard" class="menu-link d-flex align-items-center">
                              <span class="svg-icon sub-menu-icon">
                      <img class="" src="{{URL::to('/')}}/app-assets/images/icons/dashboard.png" alt=""
                   class="img-fluid">
                </span>
                        <span class="menu-text ml-3">Dashboard</span>
                    </a>
                </li>
                <li class="menu-item" aria-haspopup="true">
                    <a  href="{{ url('/') }}/showsyllabus" class="menu-link d-flex align-items-center">
                        <span class="svg-icon sub-menu-icon">
                      <img class="" src="{{URL::to('/')}}/app-assets/images/icons/icons8-books-50.png" alt=""
                   class="img-fluid">
                </span>
                        <span class="menu-text ml-3">Dashboard 1</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>
    <li class="menu-item" aria-haspopup="true">
        <a target="" href="{{ url('/') }}/studybenchlanding" class="menu-link d-flex align-items-center">
            <span class="svg-icon menu-icon">
                <img class="" src="{{URL::to('/')}}/app-assets/images/icons/image.png" alt=""
               class="img-fluid">
                <!-- <i class="fas fa-book-reader icon-md text-primary"></i> -->
            </span>
            <span class="menu-text">Study-Bench</span>
        </a>
    </li>
    <!-- <li class="menu-section">
        <h4 class="menu-text">ACADEMICS</h4>
        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
    </li> -->
   

    <li class="menu-item" aria-haspopup="true">
        <a target="" href="{{ url('/') }}/academichistory" class="menu-link d-flex align-items-center">
            <span class="svg-icon menu-icon">
                  <img class="" src="{{URL::to('/')}}/app-assets/images/icons/icons8-university-50.png" alt=""
               class="img-fluid">
                <!-- <i class="fas fa-th-list icon-md text-primary"></i> -->
            </span>
            <span class="menu-text">Academic History</span>
        </a>
    </li>
    <!-- <li class="menu-section">
        <h4 class="menu-text">ACADEMIC WORKLOAD</h4>
        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
    </li> -->
    <li class="menu-item menu-item-submenu academic_workload_menu" aria-haspopup="true" data-menu-toggle="hover">
        <a href="javascript:void(0)" class="menu-link d-flex align-items-center menu-toggle">
            <span class="svg-icon menu-icon">
                  <img class="" src="{{URL::to('/')}}/app-assets/images/icons/academic-workload.png" alt=""
               class="img-fluid">
                <!-- <i class="fas fa-th-large icon-md text-primary"></i> -->
            </span>
            <span class="menu-text">Academic Workload</span>
            <i class="menu-arrow"></i>
        </a>

        <div class="menu-submenu">
            <i class="menu-arrow"></i>
            <ul class="menu-subnav">
                <li class="menu-item menu-item-parent" aria-haspopup="true">
                    <span class="menu-link d-flex align-items-center">
                        <span class="menu-text">Academic Workload</span>
                    </span>
                </li>
                 <li class="menu-item" aria-haspopup="true">
                    <a  target="" href="{{ url('/') }}/syllabus" class="menu-link d-flex align-items-center">
                       <!--  <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i> -->
                              <span class="svg-icon sub-menu-icon">
                      <img class="" src="{{URL::to('/')}}/app-assets/images/icons/icons8-course-48.png" alt=""
                   class="img-fluid">
                </span>
                        <span class="menu-text ml-3">Syllabus</span>
                    </a>
                </li>
                <li class="menu-item" aria-haspopup="true">
                    <a  href="{{ url('/') }}/assignments" class="menu-link d-flex align-items-center">
                        <!-- <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i> -->
                        <span class="svg-icon sub-menu-icon">
                      <img class="" src="{{URL::to('/')}}/app-assets/images/icons/CL-Assignment.png" alt=""
                   class="img-fluid">
                </span>
                        <span class="menu-text ml-3">Assignments</span>
                    </a>
                </li>

                <li class="menu-item" aria-haspopup="true">
                    <a href="{{ url('/') }}/projects" class="menu-link d-flex align-items-center">
                       <!--  <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i> -->
                        <span class="svg-icon sub-menu-icon">
                      <img class="" src="{{URL::to('/')}}/app-assets/images/icons/icons8-teacher-48.png" alt=""
                   class="img-fluid">
                </span>
                        <span class="menu-text ml-3">Projects</span>
                    </a>
                </li>

                <li class="menu-item" aria-haspopup="true">
                    <a href="{{url('/')}}/exams" class="menu-link d-flex align-items-center">
                       <!--  <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i> -->
                        <span class="svg-icon sub-menu-icon">
                      <img class="" src="{{URL::to('/')}}/app-assets/images/icons/icons8-task-48.png" alt=""
                   class="img-fluid">
                </span>
                        <span class="menu-text ml-3">Exams</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>
    <li class="menu-item menu-item-submenu dl_menu" aria-haspopup="true" data-menu-toggle="hover">
        <a href="javascript:void(0)" class="menu-link d-flex align-items-center menu-toggle">
            <span class="svg-icon menu-icon svg-icon-primary">
                  <img class="" src="{{URL::to('/')}}/app-assets/images/icons/honey.png" alt=""
               class="img-fluid">
            </span>
            <span class="menu-text">Digital-Library</span>
             <i class="menu-arrow"></i>
        </a>

        <div class="menu-submenu">
            <ul class="menu-subnav">
                 <li class="menu-item" aria-haspopup="true">
                    <a  target="" href="{{ url('/') }}/digitalfiles" class="menu-link d-flex align-items-center">
                              <span class="svg-icon sub-menu-icon">
                      <img class="" src="{{url('/')}}/app-assets/images/icons/icons8-stack-overflow-32.png" alt=""
                   class="img-fluid">
                </span>
                        <span class="menu-text ml-3">Digital Files</span>
                    </a>
                </li>
                <li class="menu-item" aria-haspopup="true">
                    <a  href="{{ url('/') }}/questions" class="menu-link d-flex align-items-center">
                        <span class="svg-icon sub-menu-icon">
                      <img class="" src="{{URL::to('/')}}/app-assets/images/icons/icons8-faq-64.png" alt=""
                   class="img-fluid">
                   </span>
                        <span class="menu-text ml-3">Q & A</span>
                    </a>
                
                </li>

                <li class="menu-item" aria-haspopup="true">
                    <a href="{{ url('/') }}/notes" class="menu-link d-flex align-items-center">
                        <span class="svg-icon sub-menu-icon">
                      <img  src="{{URL::to('/')}}/app-assets/images/icons/cl-notes.png" alt=""
                   class="img-fluid" style="width: 25px;">
                </span>
                        <span class="menu-text ml-3">Notes</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>
    <li class="menu-item" aria-haspopup="true">
        <a target="" href="{{ url('/') }}/timetable" class="menu-link d-flex align-items-center">
            <span class="svg-icon menu-icon">
                <img class="" src="{{URL::to('/')}}/app-assets/images/icons/time-table.png" alt=""
               class="img-fluid">
                <!-- <i class="fas fa-table icon-md text-primary"></i>  -->
            </span>
            <span class="menu-text">Time-Table</span>
        </a>
    </li>
    <li class="menu-item" aria-haspopup="true">
        <a target="" href="{{ url('/') }}/calendar" class="menu-link d-flex align-items-center">
            <span class="svg-icon menu-icon">
                  <img class="" src="{{URL::to('/')}}/app-assets/images/icons/calendar.png" alt=""
               class="img-fluid">
                <!-- <i class="fas fa-calendar-alt icon-md text-primary"></i> -->
            </span>
            <span class="menu-text">Calendar</span>
        </a>
    </li>
    <li class="menu-item" aria-haspopup="true">
        <a  href="{{ url('/') }}/collaboration" class="menu-link d-flex align-items-center">
            <span class="svg-icon menu-icon">
                <img class="" src="{{URL::to('/')}}/app-assets/images/icons/icons8-share-64.png" alt=""
               class="img-fluid">
                 <!-- <i class="fas fa-users icon-md text-primary"></i> -->
            </span>
            <span class="menu-text">Collaboration</span>
        </a>
    </li>
</ul>