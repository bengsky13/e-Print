@php
$transaction = App\Models\Transaction::all();
$revenue = 0;
@endphp
<div class="row">
    <div class="col order-1">
        <div class="row">
            <div class="col-sm-4 col-lg-3 col-md-2 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <i class="bx bx-map-pin bx-lg" style="color: red;"></i>
                            </div>
                        </div>
                        <p class="display-5">Outlet: {{ count(App\Models\Outlet::all()) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-lg-3 col-md-2 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <i class="bx bx-history bx-lg" style="color: blue;"></i>
                            </div>
                        </div>
                        <p class="display-5">Transaction: {{ count($transaction) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-lg-3 col-md-2 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <i class="bx bx-money bx-lg" style="color: green;"></i>
                            </div>
                        </div>
                        <p class="display-5">Revenue: Rp{{ $revenue }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if(count($transaction) > 0)
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
              @php
              $item = json_decode($list);
              @endphp
              <td>{{$item->id}}</td>
              <td>{{$item->name}}</td>
              <td>{{$item->key}}</td>
              <td>@php echo $item->last_breath < (time()-5) ? '<span class="badge bg-label-danger">INACTIVE</span>' : '<span class="badge  bg-label-success">PAID</span>'@endphp</td>
              @endforeach
              
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
    <h1>No Transaction found
    @endif