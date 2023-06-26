<div class="row">
  @php
  $setting = App\Models\Setting::first();
  @endphp
  @if(session('message'))
    <div class="alert alert-success text-dark">
        {{ session('message') }}
    </div>
@endif
  <div class="container">
  <div class="py-3">
  <button type="button" class="btn btn btn-success text-dark" data-bs-toggle="modal" data-bs-target="#newOutlet">ADD NEW</button>
  </div>
  <div class="row">
    <div class="col order-1">
        <div class="row">
            <div class="col-sm-4 col-lg-3 col-md-2 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                          <p class="display-5">Setting</p>
                        </div>
                          <form action="/dashboard/setting/change" method="POST">
                            @csrf
                            <div class="row">
                              <div class="col-sm-3">
                                <label>BNW<label>
                                </div>
                              <div class="col">
                                  <input class="form-control" type="number" min="0" name="bnw" value="{{$setting->bnw}}"/>
                                </div>
                            </div>
                            <div class="row py-2">
                              <div class="col-sm-3">
                                <label>COLOR<label>
                                </div>
                              <div class="col">
                                  <input class="form-control" type="number" min="0" name="colored" value="{{$setting->colored}}"/>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success text-dark">SAVE</button>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  </div>
  </div>

  <div class="modal" id="newOutlet">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/dashboard/outlet/new" method="POST">
      @csrf
      <div class="modal-body">
          <label>Outlet Name:</label>
          <input class="form-control" type="text" name="outlet" placeholder="Outlet Name"/>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Add New</button>
        </div>
      </form>
    </div>
  </div>
</div>
