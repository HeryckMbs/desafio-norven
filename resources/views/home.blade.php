@extends('layouts.app')

@section('content')
    <!-- Main content -->

    <div class="row">
        <div class="col-6">
            <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">Manutenções por Mês</h3>
              
                  <div class="card-tools">
                    <!-- This will cause the card to maximize when clicked -->
                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                    <!-- This will cause the card to collapse when clicked -->
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    <!-- This will cause the card to be removed when clicked -->
                  </div>
                  <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                 
                <canvas id="myChart" aria-label="Hello ARIA World">
                </canvas>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->

           
        </div>
        <div class="col-6">

            <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">Entregas da semana</h3>
              
                  <div class="card-tools">
                    <!-- This will cause the card to maximize when clicked -->
                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                    <!-- This will cause the card to collapse when clicked -->
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    <!-- This will cause the card to be removed when clicked -->
                  </div>
                  <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                 
                    <div class="table table-responsive">
                        {{ $dataTable->table() }}
                    </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->


            
        </div>
    </div>


    <!-- /.content -->
@endsection

@push('scripts')

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
