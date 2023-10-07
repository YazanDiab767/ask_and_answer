@php
    use \App\Models\User;
    $i = 0;
@endphp
@foreach ($operations as $operation)
    @php
        $user = User::withTrashed()->find($operation->user_id);
    @endphp
    <tr class="tr">
        <td> {{ ++$i }} </td>
        <td> {{ date('d-m-Y h:i:s A', strtotime($operation->created_at)) }} </td>
        <td> {{ $user->name }} </td>
        <td> {{ $operation->type }} </td>
        <td> {{ $operation->details }}  </td>
        <td> <a href="{{ route('dashboard.operationsLog.delete',$operation->id) }}" class="btn btn-danger btnDelete"> Delete  </a> </td>
    </tr>
@endforeach