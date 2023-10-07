@php $isTrashed; $i = 1; @endphp
@foreach ($users as $user)
    @php
        if ($user->deleted_at) 
            $isTrashed = true;
        else
            $isTrashed = false;
    @endphp
    <tr class="tr text-center @if( $isTrashed ) bg-danger text-white  @endif ">
        <td> {{ $i++ }} </td>
        <td>
            <div class="row">
                <div class="col-sm-6 text-right">
                    <img src="{{ asset('storage/' . $user->image) }}" width="50" class="rounded-circle userImage">
                </div>
                <div class="col-sm-6 text-left" style="margin-top: 4px;">
                    <span id="username"> {{ $user->name }} </span>
                </div>
            </div>
        </td>
        <td> {{ $user->email }} </td>
        <td> {{ $user->country }} </td>
        <td> <b> {{ $user->role }} </b> </td>
        <td>
            @if ($isTrashed)
                {{ date('d-m-Y h:i:s A', strtotime($user->deleted_at)) }}
            @else
                {{ date('d-m-Y h:i:s A', strtotime($user->created_at)) }}
            @endif
        </td>
        <td style="width: 15%;">
            @if ( ! $isTrashed )
                @if ($user->role == "student")
                    <form action="" onsubmit="return false;" class="makeSupervisor w-100" method="POST">
                        @csrf
                        @method('PUT')
                        <a href="{{ $user }}" class="btn btn-sm btn-primary text-white btnMakeSupervisor w-100" data-toggle="modal" data-target=".modalSupervisor"> <i class="fa-solid fa-pen-to-square"></i> Make it supervisor </a>
                    </form>
                @elseif ($user->role == "supervisor")
                    <form action="{{ route('users.changeRole',['user' => $user->id , 'type' => 'student']) }}" onsubmit="return false;" class="makeUser w-100" method="POST">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-sm btn-success w-100"> <i class="fa-solid fa-pen-to-square"></i> Make it student </button>
                    </form>
                    <form action="{{ route('users.changeRole',['user' => $user->id , 'type' => 'admin']) }}" onsubmit="return false;" class="makeAdmin w-100" method="POST">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-sm btn-danger w-100"> <i class="fa-solid fa-pen-to-square"></i> Make it admin </button>
                    </form>
                @else
                    <form action="" onsubmit="return false;" class="makeSupervisor w-100" method="POST">
                        @csrf
                        @method('PUT')
                        <a href="{{ $user }}" class="btn btn-sm btn-primary btnMakeSupervisor w-100" data-toggle="modal" data-target=".modalSupervisor"> <i class="fa-solid fa-pen-to-square"></i> Make it supervisor </a>
                    </form>
                @endif

                {{-- form stop user ' soft delete ' --}}
                <form action="{{ route('dashboard.user.stop',$user->id) }}" class="stopUser" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-warning text-white w-100">  <i class="fas fa-stop-circle"></i> Suspended </button>
                </form>
            @else
                    {{-- form restore user --}}
                    <form action="{{ route('dashboard.user.restore',$user->id) }}"  method="POST" class="restore w-100" >
                        @csrf
                        <button class="btn btn-sm btn-primary w-100"> <i class="far fa-play-circle"></i> Restore </button>
                    </form>
                    {{-- form delete user ' force delete ' --}}
                    <form action="{{ route('dashboard.user.destroy',$user->id) }}" class="delete" method="POST">
                        @csrf
                        <button class="btn btn-sm text-white btn-warning w-100"> <i class="fas fa-trash"></i> Permanent deletion ! </button>
                    </form>
            @endif
        </td>
    </tr>
@endforeach
