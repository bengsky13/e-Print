<div class="row">
  @php
  $outlet = App\Models\Outlet::all();
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
  @if(count($outlet) > 0)
  <div class="card">
    <div class="card-datatable table-responsive">
      <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
        <div class="row">
          <table id="example" class="table table-striped" style="width:100%">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Key</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($outlet as $list)
              <tr>
              @php
              $item = json_decode($list);
              @endphp
              <td>{{$item->id}}</td>
              <td>{{$item->name}}</td>
              <td>{{$item->key}}</td>
              <td>@php echo strtotime($item->last_breath) < (time()-5) ? '<span class="badge bg-label-danger">INACTIVE</span>' : '<span class="badge  bg-label-primary">ACTIVE</span>'@endphp</td>
              @endforeach
              </tr>
            <tfoot>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Key</th>
                <th>Status</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
    @else
    <h1>No outlet found
    @endif
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
