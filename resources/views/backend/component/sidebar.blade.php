@php
    $segmentActive = explode('/',request()->path());
    

    
@endphp

<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                        <img alt="image" class="img-circle" src="img/profile_small.jpg" />
                        </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ Auth::user()->name }}</strong>
                        </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="profile.html">Profile</a></li>
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="mailbox.html">Mailbox</a></li>
                    </ul>
                </div>
            </li>
            @foreach (__('sidebar.module') as $item)
                
                <li class="">
                    <a href="index.html"><i class="{{ $item['icon'] }}"></i></i> <span class="nav-label">{{ $item['title'] }}</span> <span class="fa arrow"></span></a>
                    @if (isset($item['subTitle']))
                    <ul class="nav nav-second-level">
                        @foreach ($item['subTitle'] as $sub)   
                        {{-- @dd($sub); --}}
                            <li class="{{ setActive($sub['set'],$segmentActive) }}"><a href="{{ $sub['route'] }}">{{ $sub['title'] }}</a></li>      
                        @endforeach
                    </ul>
                    @endif                
                </li>
            @endforeach
            
        </ul>

    </div>
</nav>
