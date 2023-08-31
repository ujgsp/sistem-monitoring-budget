<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $title; ?></h1>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <!-- budget opex -->
            <h5 class="mb-2">Budget Opex</h5>
            <div class="row">
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fa fa-fw fa-arrow-down"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Initial Budget</span>
                            <span class="info-box-number initbudgetopex">0</span>
                        </div>

                    </div>

                </div>

                <div class="col-md-4 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fa fa-fw fa-arrow-up"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Budgets Used</span>
                            <span class="info-box-number budgetuseropex">0</span>
                        </div>

                    </div>

                </div>

                <div class="col-md-4 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fa fa-fw fa-tag"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Remaining Budget</span>
                            <span class="info-box-number remainingbudgetopex">0</span>
                        </div>

                    </div>

                </div>

            </div>

            <!-- budget capex -->
            <h5 class="mb-2">Budget Capex</h5>
            <div class="row">
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fa fa-fw fa-arrow-down"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Initial Budget</span>
                            <span class="info-box-number initbudgetcapex">0</span>
                        </div>

                    </div>

                </div>

                <div class="col-md-4 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fa fa-fw fa-arrow-up"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Budgets Used</span>
                            <span class="info-box-number budgetusercapex">0</span>
                        </div>

                    </div>

                </div>

                <div class="col-md-4 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fa fa-fw fa-tag"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Remaining Budget</span>
                            <span class="info-box-number remainingbudgetcapex">0</span>
                        </div>

                    </div>

                </div>

            </div>

            <!-- chart -->
            <h5 class="mb-2">Chart</h5>
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">
                                Budget
                            </h3>
                            <div class="card-tools">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="dt_budget" value="<?php echo date('Y') ?>">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <select class="custom-select" id="filter_kategori">
                                                <option value="" selected>All Categories</option>
                                                <option value="capex">Capex</option>
                                                <option value="opex">Opex</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <select class="custom-select" id="filter_lokasi">
                                                <option value="" selected>All Locations</option>
                                                <option value="ho">Head Office</option>
                                                <option value="bo">Branch Office</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="card-body">
                            <div id="bar-example" style="width:100%; height:280px;"></div>
                        </div>

                    </div>

                </div>

                <div class="col-md-4">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">
                                Vendor
                            </h3>
                            <div class="card-tools">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="dt_vendor" value="<?php echo date('Y') ?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="card-body">
                            <div id="donut_chart" style="width:100%; height:280px;"></div>
                        </div>

                    </div>

                </div>

            </div>

            <!-- chart -->
            <h5 class="mb-2">Table</h5>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                Master Budget
                            </h3>
                            <div class="card-tools">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="dt_master_budget" value="<?php echo date('Y') ?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Opex</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Capex</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="custom-content-below-tabContent">
                                <div id="divTable"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
    $(function() {
        //Date picker

        changeDate('dt_budget');
        changeDate('dt_vendor');
        changeDate('dt_master_budget');

        function changeDate(elementId) {
            $("#" + elementId).datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                autoclose: true,
            });

        }

        /* counting */
        getCount('initbudgetopex', 'budgetuseropex', 'remainingbudgetopex', 'opex');
        getCount('initbudgetcapex', 'budgetusercapex', 'remainingbudgetcapex', 'capex');

        function getCount(elementTotalBudget, elementTotalPenggunaan, elementTotalSaldo, category) {
            $.ajax({
                url: "<?= base_url('dashboard/counttotal') ?>",
                type: "get",
                data: {
                    'category': category,
                },
                dataType: "json",
                success: function(data) {
                    // console.log(data);
                    $('.' + elementTotalBudget).text(data.total_budget);
                    $('.' + elementTotalPenggunaan).text(data.total_penggunaan);
                    $('.' + elementTotalSaldo).text(data.total_saldo);
                }
            });

        }

        /* bar chart morris */
        var data_bar_chart = [];

        makebarchart('bar', '', '', $('#dt_budget').val());

        function makebarchart(chartType, category = NULL, location = NULL, year) {
            $.ajax({
                url: "<?= base_url('dashboard/chart') ?>",
                type: "get",
                data: {
                    'type': chartType,
                    'category': category,
                    'location': location,
                    'year': year
                },
                dataType: "JSON",
                success: function(data_bar_chart) {
                    bar_chart.setData(data_bar_chart);
                }
            })
        }

        var bar_chart = Morris.Bar({
            element: 'bar-example',
            data: data_bar_chart,
            xkey: 'y',
            ykeys: ['a'],
            labels: ['Budget'],
            lineWidth: '3px',
            resize: true,
            // xLabelAngle: 60
        });

        // event
        $('#dt_budget').change(function(e) {
            e.preventDefault();
            makebarchart('bar', $('#filter_kategori').find(":selected").val(), $('#filter_lokasi').find(":selected").val(), $('#dt_budget').val());
        });

        $('#filter_kategori').change(function(e) {
            e.preventDefault();
            makebarchart('bar', $('#filter_kategori').find(":selected").val(), $('#filter_lokasi').find(":selected").val(), $('#dt_budget').val());
        });

        $('#filter_lokasi').change(function(e) {
            e.preventDefault();
            makebarchart('bar', $('#filter_kategori').find(":selected").val(), $('#filter_lokasi').find(":selected").val(), $('#dt_budget').val());
        });

        // pie chart vendor
        var tahunVendor = $('#dt_vendor').val();
        var donut_vendor = null;

        drawPieChart('donut_chart');

        function drawPieChart(elementId) {
            donut_vendor = Morris.Donut({
                element: elementId,
                data: [{
                    label: "No Data",
                    value: 0
                }],
            });
        }

        ajaxPieChart(tahunVendor);

        function ajaxPieChart(year) {
            $.ajax({
                url: "<?php echo base_url('dashboard/chart') ?>",
                type: "get",
                data: {
                    'type': 'pie',
                    'year': year
                },
                dataType: "json",
                success: function(data) {
                    if (data.length == 0) {
                        data.push({
                            label: "No Data",
                            value: 0
                        });
                    }
                    donut_vendor.setData(data);
                    donut_vendor.redraw();
                }
            })
        }

        $(document).on('change', '#dt_vendor', function() {
            ajaxPieChart($(this).val());
        });

        /* table master */
        var tahun = $('#dt_master_budget').val();

        loadTableMaster(tahun, 'Opex');

        function loadTableMaster(tahun, type) {
            $.ajax({
                url: "<?php echo base_url() ?>dashboard/datatable/" + tahun + "/" + type,
                type: "POST",
                success: function(data) {
                    $('#divTable').html(data);
                }
            })
        }

        $('.nav-tabs a ').on('shown.bs.tab', function(event) {
            var tab_target = $(event.target).text();
            // console.log(tab_target);
            switch (tab_target) {
                case 'Capex':
                    loadTableMaster(tahun, tab_target);
                    break;
                case 'Opex':
                    loadTableMaster(tahun, tab_target);
                    break;
            }
        });

        // event change tahun master budget
        $(document).on('change', '#dt_master_budget', function() {
            // e.preventDefault();
            loadTableMaster($(this).val(), 'Opex');
            // console.log($('#dt_master_budget_val').val());
            tahun = $(this).val()

            $('.nav-tabs a ').on('shown.bs.tab', function(event) {
                var tab_target = $(event.target).text();
                // console.log(tab_target);
                switch (tab_target) {
                    case 'Capex':
                        loadTableMaster(tahun, tab_target);
                        break;
                    case 'Opex':
                        loadTableMaster(tahun, tab_target);
                        break;
                }
            });
        })
    });
</script>