@extends('layouts.admin')

@section('content')

<style>
  @media print {
    .noprint {
      visibility : hidden !important;
    }

     @page {
        margin: 0;
    }
    body {
        -webkit-print-color-adjust: exact;
    }
  }
</style>

<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">


<!--begin::Container-->
<div class="container-xxl" id="form_ubah_web_profile">

    <div class="row mb-5">
        <div class="col-xl-8 row d-flex justify-content-start align-items-start flex-column">
            <div class="col-xl-12 mb-7">
                <div class="card mb-5 mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <!--begin::Page title-->
                        <div class="page-title d-flex align-items-center">
                            <!--begin::Title-->
                            <h1 class="d-flex text-primary fw-bold m-0 fs-3">Transaksi Penjualan</h1>
                            <!--end::Title-->
                        </div>
                        <div class="d-flex justify-content-end noprint" style="width : 300px">
                            <div class="me-4" style="width : 150px">
                              <select name="month" onchange="selectDateFilter(this)" class="form-select form-select-solid filter-input" data-control="select2" data-placeholder="Pilih bulan">
                                <option value="all">Semua</option>
                                @for ($i = 1; $i <= 12; $i++)
                                  <option value="{{ $i }}" <?= ($bulan == $i) ? 'selected' : '';?>>{{ getMonthById($i) }}</option>
                                @endfor
                              </select>
                            </div>
                            
                            <div style="width : 100px">
                              <select name="year" onchange="selectDateFilter(this)" class="form-select form-select-solid filter-input" data-control="select2" data-placeholder="Pilih tahun">
                                @for ($year = 2024; $year <= date('Y'); $year++)
                                  <option value="{{ $year }}" <?= ($tahun == $year) ? 'selected' : '';?>>{{ $year }}</option>
                                @endfor      
                              </select>
                            </div>

                            <script>
                                function selectDateFilter(select) {
                                  const paramName = select.name;
                                  const value = select.value;
                                  const url = new URL(window.location.href);
                                  const params = new URLSearchParams(url.search);

                                  if (value) {
                                    params.set(paramName, value); // Tambah atau update parameter sesuai name select
                                  } else {
                                    params.delete(paramName); // Hapus parameter jika value kosong
                                  }

                                  window.location.href = `${url.pathname}?${params.toString()}`;
                                }
                            </script>
                        </div>
                        <!--end::Page title-->
                    </div>
                    <div class="card-body py-3" >
                        <div id="transactionbar" style="min-height : 450px; height : auto;"></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12">
                <div class="card mb-5 mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <!--begin::Page title-->
                        <div class="page-title d-flex align-items-center">
                            <!--begin::Title-->
                            <h1 class="d-flex text-primary fw-bold m-0 fs-3">Distribusi Persebaran Pelanggan</h1>
                            <!--end::Title-->
                        </div>
                        <!--end::Page title-->
                    </div>
                    <div class="card-body py-3" >
                        <div id="maping" style="min-height : 450px; height : auto;"></div>
                    </div>
                </div>
            </div>
            

        </div>
        <div class="col-xl-4 row d-flex justify-content-start align-items-start flex-column">
            <div class="col-xl-12 row mb-4 noprint">
                <div class="col-xl-4 d-flex justify-content-center align-items-center">
                  <button type="button" onclick="window.print()" class="btn btn-sm btn-primary">Cetak</button>
                </div>
                <div class="col-xl-8 d-flex justify-content-end align-items-center">
                    <a href="{{ route('profile') }}" style="width: 55px; height: 55px; 
                        background-image: url('{{ image_check(session(config('session.prefix') . '_image'), 'user','user') }}'); 
                        background-position: center; 
                        background-size: cover; 
                        background-repeat: no-repeat;
                        border-radius : 100%;
                        ">
                    </a>

                </div>
            </div>
            <div class="col-xl-12 mb-5 noprint" >
                <!--begin::Stats Widget 1-->
                <div class="card card-custom bgi-no-repeat card-border gutter-b card-stretch" style="background-position: right top; background-size: 30% auto;">
                    <!--begin::Body-->
                    <div class="card-body" style="padding-top : 10px;">
                        @if($trend)
                        <div class="text-dark fw-bold mt-3 mb-2 fs-2"># Tren Produk</div>
                        <span class="text-muted fs-3"><i class="fa-solid fa-arrow-trend-up text-dark fs-3 me-2"></i>{{ $trend->name }}</span>
                        @else
                        <div class="alert alert-danger">Tidak ada transaksi terdeteksi</div>
                        @endif
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 1-->
            </div>

            <div class="col-xl-12 mb-5 noprint">
                <!--begin::Stats Widget 1-->
                <div class="card card-custom bgi-no-repeat card-border gutter-b card-stretch" style="background-position: right top; background-size: 30% auto;">
                    <!--begin::Body-->
                    <div class="card-body" style="padding-top : 10px;">
                        <div class="text-dark fw-bold mt-3 mb-2 fs-2">Transaksi Terakhir</div>
                        <div class="row">
                          @if(!$last_transaction)
                          <div class="alert alert-danger">Tidak ada transaksi terdeteksi</div>
                          @else
                          
                          <div class="col-xl-5" style="border-right : 2px solid var(--bs-primary)">
                            <span class="text-muted fs-4">{{ date('d-m-Y',strtotime($last_transaction->tanggal_transaksi))}}</span>
                          </div>
                          <div class="col-xl-7">
                            <span class="text-muted fs-4">Pembelian {{ $last_transaction->name }} oleh {{ $last_transaction->pelanggan }} senilai {{ number_format($last_transaction->price,0,',','.') }}</span>
                          </div>
                          @endif
                          
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 1-->
            </div>

            <div class="col-xl-12 mb-5">
                <!--begin::Stats Widget 1-->
                <div class="card card-custom bgi-no-repeat card-border gutter-b card-stretch" style="background-position: right top; background-size: 30% auto;">
                    <!--begin::Body-->
                    <div id="bunder" class="card-body d-flex flex-column" style="padding-top : 10px;">
                        <div class="text-dark fw-bold mt-3 mb-2 fs-2">Stok Barang</div>
                        <?php
                          $pieie = json_decode($pie);
                        ?>
                        @if($pieie[0]->value > 0 && $pieie[1]->value > 0) 
                        <div id="stokChart" style="min-height : 300px; height : auto;"></div>
                        @else
                        <div class="alert alert-danger">Tidak ada transaksi terdeteksi</div>
                        @endif
                        
                         <div class="text-dark fw-bold mt-3 mb-2 fs-2">Top 5 Produk Terlaris</div>
                        @if(json_decode($donut)) 
                        <div id="trendChart" style="min-height : 300px; height : auto;"></div>
                        @else
                        <div class="alert alert-danger">Tidak ada transaksi terdeteksi</div>
                        @endif
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 1-->
            </div>
        </div>

        <div class="col-xl-12">
            <div class="card mb-5 mb-xl-8">
                <!--begin::Body-->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <!--begin::Page title-->
                    <div class="page-title d-flex align-items-center">
                        <!--begin::Title-->
                        <h1 class="d-flex text-primary fw-bold m-0 fs-3">Analisis Tingkat Penjualan Berdasarkan Kategori</h1>
                        <!--end::Title-->
                    </div>
                    <!--end::Page title-->
                </div>
                <div class="card-body py-3" >
                    <div id="rowbar" style="min-height : 450px; height : auto;"></div>
                </div>
            </div>
        </div>
        
    </div>


    


  
</div>
</div>

<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/indonesiaLow.js"></script>



<!-- CHART -->
<script>
  am5.ready(function() {

  // Ambil nilai var(--bs-primary) dari CSS
  var primaryColor = getComputedStyle(document.documentElement).getPropertyValue('--bs-primary').trim();

  // Create root element
  var root = am5.Root.new("transactionbar");

  // Set themes
  root.setThemes([
    am5themes_Animated.new(root)
  ]);

  // Create chart
  var chart = root.container.children.push(am5xy.XYChart.new(root, {
    panX: true,
    panY: true,
    wheelX: "panX",
    wheelY: "zoomX",
    pinchZoomX: true,
    paddingLeft:0,
    paddingRight:1
  }));

  // Add cursor
  var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
  cursor.lineY.set("visible", false);

  // Create axes
  var xRenderer = am5xy.AxisRendererX.new(root, { 
    minGridDistance: 30, 
    minorGridEnabled: true
  });

  xRenderer.labels.template.setAll({
    visible: false
  });

  xRenderer.grid.template.setAll({
    location: 1
  });

  var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
    maxDeviation: 0.3,
    categoryField: "category",
    renderer: xRenderer,
    tooltip: am5.Tooltip.new(root, {})
  }));

  var yRenderer = am5xy.AxisRendererY.new(root, {
    strokeOpacity: 0.1
  });

  var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
    maxDeviation: 0.3,
    renderer: yRenderer
  }));

  // Create series
  var series = chart.series.push(am5xy.ColumnSeries.new(root, {
    name: "Grafik penjualan",
    xAxis: xAxis,
    yAxis: yAxis,
    valueYField: "value",
    sequencedInterpolation: true,
    categoryXField: "category",
    tooltip: am5.Tooltip.new(root, {
      labelText: "{valueY} Transaksi"
    })
  }));

  series.columns.template.setAll({ cornerRadiusTL: 5, cornerRadiusTR: 5, strokeOpacity: 0 });

  // Gunakan var(--bs-primary) untuk warna chart
  series.columns.template.adapters.add("fill", function () {
    return am5.color(primaryColor);
  });

  series.columns.template.adapters.add("stroke", function () {
    return am5.color(primaryColor);
  });

  // Set data
  var data = <?= $bar; ?>

  xAxis.data.setAll(data);
  series.data.setAll(data);

  // Make stuff animate on load
  series.appear(1000);
  chart.appear(1000, 100);

  }); // end 
  am5.ready();

</script>



<!-- PIE -->
<script>
    am5.ready(function() {

      // Ambil warna dari CSS variable Bootstrap
      function getCSSVariable(varName) {
          return getComputedStyle(document.documentElement).getPropertyValue(varName).trim();
      }

      // Ambil warna Bootstrap
      var primaryColor = getCSSVariable('--bs-primary') || '#34251D'; // Default: biru
      var secondaryColor = getCSSVariable('--bs-soft-primary') || '#B8925A'; // Default: abu-abu

      // Create root element
      var root = am5.Root.new("stokChart");

      // Set themes
      root.setThemes([
        am5themes_Animated.new(root)
      ]);

      // Create chart
      var chart = root.container.children.push(
        am5percent.PieChart.new(root, {
          endAngle: 270
        })
      );

      // Create series
      var series = chart.series.push(
        am5percent.PieSeries.new(root, {
          valueField: "value",
          categoryField: "category",
          endAngle: 270
        })
      );

      // ** Terapkan warna Bootstrap ke AmCharts **
      series.set("colors", am5.ColorSet.new(root, {
        colors: [
          am5.color(primaryColor),   // Warna dari Bootstrap
          am5.color(secondaryColor)  // Warna dari Bootstrap
        ]
      }));

      // Hilangkan label pada Pie Chart agar fokus ke legend
      series.labels.template.set("visible", false);
      series.ticks.template.set("visible", false);

      // Create legend
      var legend = chart.children.push(am5.Legend.new(root, {
        centerX: am5.p50,
        x: am5.p50
      }));

      // Ubah legend jadi bentuk bar (rectangle)
      legend.markerRectangles.template.setAll({
        width: 20,   // Lebar bar
        height: 10,  // Tinggi bar
        cornerRadiusTL: 0,
        cornerRadiusTR: 0
      });

      // Set data ke chart
      var data = <?= $pie; ?>;
      series.data.setAll(data);

      // Set legend untuk mengambil data dari series
      legend.data.setAll(series.dataItems);

      series.appear(1000, 100);

      }); // end am5.ready()

</script>

<!-- DONNUT -->
<script>
      am5.ready(function() {

        // Warna dari gambar
        var customColors = [
            am5.color("#dbcfaa"), // Warna 1
            am5.color("#34251d"), // Warna 2
            am5.color("#ecf3fa"), // Warna 3
            am5.color("#b8925a"), // Warna 4
            am5.color("#5c5d57")  // Warna 5
        ];

        // Create root element
        var root = am5.Root.new("trendChart");

        // Set themes
        root.setThemes([
          am5themes_Animated.new(root)
        ]);

        // Create chart
        var chart = root.container.children.push(am5percent.PieChart.new(root, {
          layout: root.verticalLayout,
          innerRadius: am5.percent(50) // Donut
        }));

        // Create series
        var series = chart.series.push(am5percent.PieSeries.new(root, {
          valueField: "value",
          categoryField: "category",
          alignLabels: false
        }));

        // ** Hilangkan label di sekitar donut **
        series.labels.template.set("visible", false);
        series.ticks.template.set("visible", false);

        // Terapkan warna baru ke chart
        series.set("colors", am5.ColorSet.new(root, {
          colors: customColors
        }));

        // Set data
        var data = <?= $donut; ?>;
        series.data.setAll(data);

        // Create legend
        var legend = chart.children.push(am5.Legend.new(root, {
          centerX: am5.percent(50),
          x: am5.percent(50),
          marginTop: 15,
          marginBottom: 15,
        }));

        // Ubah marker legend jadi rectangle (bar)
        legend.markerRectangles.template.setAll({
          width: 20,
          height: 10,
          cornerRadiusTL: 0,
          cornerRadiusTR: 0
        });

        legend.data.setAll(series.dataItems);

        // Play animation
        series.appear(1000, 100);

        }); // end am5.ready()

</script>


<!-- ROW -->
<script>
    am5.ready(function() {
      var primaryColor = getComputedStyle(document.documentElement).getPropertyValue('--bs-soft-primary').trim();

    // Create root element
    // https://www.amcharts.com/docs/v5/getting-started/#Root_element
    var root = am5.Root.new("rowbar");


    // Set themes
    // https://www.amcharts.com/docs/v5/concepts/themes/
    root.setThemes([
      am5themes_Animated.new(root)
    ]);


    // Create chart
    // https://www.amcharts.com/docs/v5/charts/xy-chart/
    var chart = root.container.children.push(am5xy.XYChart.new(root, {
      panX: false,
      panY: false,
      wheelX: "none",
      wheelY: "none",
      paddingLeft: 0
    }));

    // We don't want zoom-out button to appear while animating, so we hide it
    chart.zoomOutButton.set("forceHidden", true);


    // Create axes
    // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
    var yRenderer = am5xy.AxisRendererY.new(root, {
      minGridDistance: 30,
      minorGridEnabled: true
    });

    yRenderer.grid.template.set("location", 1);

    var yAxis = chart.yAxes.push(am5xy.CategoryAxis.new(root, {
      maxDeviation: 0,
      categoryField: "category",
      renderer: yRenderer,
      tooltip: am5.Tooltip.new(root, { themeTags: ["axis"] })
    }));

    var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
      maxDeviation: 0,
      min: 0,
      numberFormatter: am5.NumberFormatter.new(root, {
        "numberFormat": "#,###a"
      }),
      extraMax: 0.1,
      renderer: am5xy.AxisRendererX.new(root, {
        strokeOpacity: 0.1,
        minGridDistance: 80

      })
    }));

    xAxis.get("numberFormatter").set("numberFormat", "#");


    // Add series
    // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
    var series = chart.series.push(am5xy.ColumnSeries.new(root, {
      name: "Series 1",
      xAxis: xAxis,
      yAxis: yAxis,
      valueXField: "value",
      categoryYField: "category",
      tooltip: am5.Tooltip.new(root, {
        pointerOrientation: "left",
        labelText: "{valueX}"
      })
    }));


    // Rounded corners for columns
    series.columns.template.setAll({
      cornerRadiusTR: 5,
      cornerRadiusBR: 5,
      strokeOpacity: 0
    });

     // Gunakan var(--bs-primary) untuk warna chart
    series.columns.template.adapters.add("fill", function () {
      return am5.color(primaryColor);
    });

    series.columns.template.adapters.add("stroke", function () {
      return am5.color(primaryColor);
    });


    // Set data
    var data = <?= $grow; ?>;

    yAxis.data.setAll(data);
    series.data.setAll(data);
    sortCategoryAxis();

    // Get series item by category
    function getSeriesItem(category) {
      for (var i = 0; i < series.dataItems.length; i++) {
        var dataItem = series.dataItems[i];
        if (dataItem.get("categoryY") == category) {
          return dataItem;
        }
      }
    }

    chart.set("cursor", am5xy.XYCursor.new(root, {
      behavior: "none",
      xAxis: xAxis,
      yAxis: yAxis
    }));


    // Axis sorting
    function sortCategoryAxis() {

      // Sort by value
      series.dataItems.sort(function (x, y) {
        return x.get("valueX") - y.get("valueX"); // descending
        //return y.get("valueY") - x.get("valueX"); // ascending
      })

      // Go through each axis item
      am5.array.each(yAxis.dataItems, function (dataItem) {
        // get corresponding series item
        var seriesDataItem = getSeriesItem(dataItem.get("category"));

        if (seriesDataItem) {
          // get index of series data item
          var index = series.dataItems.indexOf(seriesDataItem);
          // calculate delta position
          var deltaPosition = (index - dataItem.get("index", 0)) / series.dataItems.length;
          // set index to be the same as series data item index
          dataItem.set("index", index);
          // set deltaPosition instanlty
          dataItem.set("deltaPosition", -deltaPosition);
          // animate delta position to 0
          dataItem.animate({
            key: "deltaPosition",
            to: 0,
            duration: 1000,
            easing: am5.ease.out(am5.ease.cubic)
          })
        }
      });

      // Sort axis items by index.
      // This changes the order instantly, but as deltaPosition is set,
      // they keep in the same places and then animate to true positions.
      yAxis.dataItems.sort(function (x, y) {
        return x.get("index") - y.get("index");
      });
    }


    // Make stuff animate on load
    // https://www.amcharts.com/docs/v5/concepts/animations/
    series.appear(1000);
    chart.appear(1000, 100);

    }); // end am5.ready()
</script>


<!-- MAP -->
<script>
    am5.ready(function () {
        var root = am5.Root.new("maping");
        root.setThemes([am5themes_Animated.new(root)]);

        var chart = root.container.children.push(
            am5map.MapChart.new(root, {
                panX: "translateX",
                panY: "translateY",
                projection: am5map.geoMercator()
            })
        );

        var indonesiaSeries = chart.series.push(
            am5map.MapPolygonSeries.new(root, {
                geoJSON: am5geodata_indonesiaLow,
                fill: am5.color(0x4c6ef5) // Warna biru seperti di gambar
            })
        );

        var pointSeries = chart.series.push(
            am5map.MapPointSeries.new(root, {})
        );
        var pointData = <?= $map;?>;

        pointSeries.bullets.push(function (root, series, dataItem) {
            var circle = am5.Circle.new(root, {
                radius: 6,
                fill: am5.color(0x000000),
                tooltipText: dataItem.dataContext.title // Tooltip sesuai dengan titik
            });

            return am5.Bullet.new(root, { sprite: circle });
        });

        pointSeries.data.setAll(pointData.map(function (data) {
            return {
                geometry: { type: "Point", coordinates: [data.longitude, data.latitude] },
                title: data.title
            };
        }));

        chart.appear(1000, 100);
    });
</script>
@endsection
