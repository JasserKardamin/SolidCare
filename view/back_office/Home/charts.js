function getCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) {
      var c = ca[i];
      while (c.charAt(0)==' ') c = c.substring(1,c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
  }
  return null;
}

var p_number = getCookie('p_number');
var n_number = getCookie('n_number') ; 

var summ =  p_number + n_number ; 

var p_perc = (p_number / summ)*100 ; 
var n_perc = (n_number / summ)* 100 ; 

var options = {
  series: [
    {
      name: 'Patients',
      data: [44, 55, 41, 67, 22, p_number ],
      color: '#2962ff' 
    },
    {
      name: 'Nurses',
      data: [13, 23, 20, 8, 13, n_number ],
      color: '#ff6d00'
    }
  ],
  chart: {
    type: 'bar',
    height: 350,
    width: 800,
    stacked: true,
    toolbar: {
      show: true
    },
    zoom: {
      enabled: true
    }
  },
  plotOptions: {
    bar: {
      horizontal: false,
      borderRadius: 10
    }
  },
  xaxis: {
    type: 'category',
    categories: ['2018', '2019', '2020', '2021', '2022', '2023'],
    labels: {
      formatter: function (val) {
        return val;
      },
      style: {
        colors: '#fff'
      }
    }
  },
  yaxis: {
    labels: {
      style: {
        colors: '#fff'
      }
    }
  },
  legend: {
    position: 'top',
    offsetY: 0,
    labels: {
      colors: '#fff'
    }
  },
  fill: {
    opacity: 1
  }
};

var chart = new ApexCharts(document.querySelector("#bar-chart"), options);
chart.render();

// AREA CHART

const areaChartOptions = {
  series: [
    {
      name: 'Income',
      data: [31, 40, 28, 51, 42, 109, 100],
    },
    {
      name: 'Fees',
      data: [11, 32, 45, 32, 34, 52, 41],
    },
  ],
  chart: {
    type: 'area',
    background: 'transparent',
    height: 350,
    stacked: false,
    toolbar: {
      show: false,
    },
  },
  colors: ['#00ab57', '#d50000'],
  labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
  dataLabels: {
    enabled: false,
  },
  fill: {
    gradient: {
      opacityFrom: 0.4,
      opacityTo: 0.1,
      shadeIntensity: 1,
      stops: [0, 100],
      type: 'vertical',
    },
    type: 'gradient',
  },
  grid: {
    borderColor: '#55596e',
    yaxis: {
      lines: {
        show: true,
      },
    },
    xaxis: {
      lines: {
        show: true,
      },
    },
  },
  legend: {
    labels: {
      colors: '#f5f7ff',
    },
    show: true,
    position: 'top',
  },
  markers: {
    size: 6,
    strokeColors: '#1b2635',
    strokeWidth: 3,
  },
  stroke: {
    curve: 'smooth',
  },
  xaxis: {
    axisBorder: {
      color: '#55596e',
      show: true,
    },
    axisTicks: {
      color: '#55596e',
      show: true,
    },
    labels: {
      offsetY: 5,
      style: {
        colors: '#f5f7ff',
      },
    },
  },
  yaxis: [
    {
      title: {
        text: 'Income',
        style: {
          color: '#f5f7ff',
        },
      },
      labels: {
        style: {
          colors: ['#f5f7ff'],
        },
      },
    },
    {
      opposite: true,
      title: {
        text: 'Fees',
        style: {
          color: '#f5f7ff',
        },
      },
      labels: {
        style: {
          colors: ['#f5f7ff'],
        },
      },
    },
  ],
  tooltip: {
    shared: true,
    intersect: false,
    theme: 'dark',
  },
};

const areaChart = new ApexCharts(
  document.querySelector('#area-chart'),
  areaChartOptions
);
areaChart.render();
