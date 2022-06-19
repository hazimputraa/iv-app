@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('User List') }}
                  <div class="row text-right">
                    <button type="button" class="btn btn-sm btn-icon btn-icon-only text-success" onclick="showForm('add')" title="Tambah Pengguna"><i class="fas fa-user-plus btn-icon-wrapper"> </i></button>
                  </div>
                </div>
                <div class="card-body">
                    <div class="content-top d-none">
                        @include('user_detail')
                    </div>
                    <div class="content-bottom">
                        @if (!empty($users))
                        <table id="userList" class="table table-hover table-striped table-bordered" style="width:100%;">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone No</th>
                                <th>&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <th scope="row" class="align-text-top text-right">{{ $loop->index + 1 }}</th>
                                <td class="align-text-top">{{ $user['name'] }}</td>
                                <td class="align-text-top">{{ $user['email'] }}</td>
                                <td class="align-text-top">{{ $user['phone_no'] }}</td>
                                <td class="align-text-top align-center">
                                    <button class="btn btn-sm btn-icon-vertical" onclick="getDetail( {{ $user['id'] }} )" title="Update">
                                      <i class="fas fa-edit btn-icon-wrapper"></i>
                                    </button>
                                    <button class="btn btn-sm btn-icon-vertical" onclick="goDelete( {{ $user['id'] }}, '{{ $user['name'] }}')" title="Delete">
                                      <i class="fas fa-times btn-icon-wrapper"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @else
                        <div>No Record</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
$(document).ready(() => {
    $('table#userList').DataTable({
      columns: [
        {width: '5%'},
        {width: '30%'},
        {width: '15%'},
        {width: '7%'},
        {width: '8%', sortable: false},
      ]
    });
});
function getDetail(id) {
    $.get(`/user/detail/${id}`, (data) => {
      $('.content-top').html(data);
      showForm('edit');
    });
}
function showForm(action) {
    var header_content = $('.card-header').html();
    var close_button = $(
      '<div class="row text-right"><button type="button" class="btn btn-sm btn-icon btn-icon-only text-danger text-right" title="Close">\n' +
      '<i class="fas fa-times btn-icon-wrapper"> </i>\n' +
      '</button></div>\n'
    );
    //for close button
    $(close_button).on('click', function() {
      
        //clearForm('');
        $('.card-header').html(header_content);
        $('.content-top').slideUp('slow').addClass('d-none');
        $('.content-bottom').fadeIn('slow');
      
    });
    $('.content-bottom').hide();
    $('.content-top').removeClass('d-none').slideDown('slow');
    if (action === 'add') {
      $('.card-header')
        .empty()
        .append($('<i class="header-icon fas fa-plus icon-gradient bg-plum-plate"> </i>'))
        .append('Add User')
        .append($('<div class="btn-actions-pane-right actions-icon-btn"></div>').append($(close_button)));
    }
    else {
      $('.card-header')
        .empty()
        .append($('<i class="header-icon fas fa-edit icon-gradient bg-plum-plate"> </i>'))
        .append('Update User')
        .append($('<div class="btn-actions-pane-right actions-icon-btn"></div>').append($(close_button)));
    }
}
function goDelete(id, name) {
  if(confirm(`Are you sure want to delete ${name}?`)){
    $.ajax({
          url: `/user/delete/${id}`,
          method: 'POST',
          data: {'id': id, '_token': '{{ csrf_token() }}'},
          dataType: 'json',
          success: (data) => {
            if (data.success){
              toastr.success('Successdul!');
              setTimeout(window.location = "/home", 5000);
            }
          }
        });
  }
  else
    console.log('cancel');
}
</script>