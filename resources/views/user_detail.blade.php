      @php
      $controller = Request()->route()->getActionName();
      $controller_func = explode('@', $controller)[1];
      @endphp
      <form id="UserForm" class="">
        @csrf
        <div class="position-relative row form-group mb-2">
          <label for="name" class="col-form-label col-sm-3 font-weight-bold">Name</label>
          <div class="col-sm-6">
            <input type="text" name="name" id="name" class="form-control form-control-sm" value="@if (! empty($user)){{ $user->name }}@endif">
          </div>
        </div>
        <div class="position-relative row form-group mb-2">
          <label for="email" class="col-form-label col-sm-3 font-weight-bold">Email</label>
          <div class="col-sm-6">
          <input type="text" name="email" id="email" class="form-control form-control-sm" value="@if (! empty($user)){{ $user->email }}@endif">
          </div>
        </div>
        <div class="position-relative row form-group mb-2">
          <label for="phone_no" class="col-form-label col-sm-3 font-weight-bold">Phone No</label>
          <div class="col-sm-6">
             <input type="text" name="phone_no" id="phone_no" class="form-control form-control-sm" value="@if (! empty($user)){{ $user->phone_no }}@endif">
          </div>
        </div>
        <div class="position-relative row form-group mb-2">
        <label for="password" class="col-form-label col-sm-3 font-weight-bold">Password</label>
            <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" @if ($controller_func === 'add') required @endif autocomplete="new-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="position-relative row form-group mb-2">
        <label for="password-confirm" class="col-form-label col-sm-3 font-weight-bold">Confirm Password</label>
            <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" @if ($controller_func === 'add') required @endif autocomplete="new-password">
            </div>
        </div>
        <div class="d-block text-right card-footer row">
          <button type="submit" class="btn btn-icon btn-hover-shine btn-primary"><i class="fas fa-save btn-icon-wrapper"> </i>Save</button>
        </div>
      </form>
<script type="text/javascript">
  $(document).ready(() => {
    $('form#UserForm').validate({
      rules: {
        name: {
          required: true,
          maxlength: 150
        },
        email: {
          required: true,
        },
      },
      messages: {
        name: {
          required: 'Please insert Name',
          maxlength: ' Name cannot exceed 150 characters'
        },
        email: {
          required: 'Please enter email',
        },
      },
      submitHandler: (form) => {
        $.ajax({
          url: '/user/@if ($controller_func === 'detail' and ! empty($user)){{ 'detail/' }}{{ $user->id }}@else{{ 'add' }}@endif',
          method: 'POST',
          data: $(form).serialize(),
          dataType: 'json',
          success: (data) => {
            if (data.success){
              toastr.success('Successdul!');
              setTimeout(window.location = "/home", 5000);
            }
          }
        });
      }
    });
  });
</script>
