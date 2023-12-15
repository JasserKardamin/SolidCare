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

// Retrieve and display the values of the cookies

var plan1Name = getCookie('plan1_name');
var plan1SubscriptionCount = getCookie('plan1_subscription_count');

var plan2Name = getCookie('plan2_name');
var plan2SubscriptionCount = getCookie('plan2_subscription_count');

var plan3Name = getCookie('plan3_name');
var plan3SubscriptionCount = getCookie('plan3_subscription_count');


if (plan3Name == null && plan3SubscriptionCount == null ){ 
    plan3Name = "plan3" ; 
    plan3SubscriptionCount = 0 ;
    var percentage3 = 0  ; 
}

if (plan1Name == null && plan1SubscriptionCount == null ){ 
    plan1Name = "plan1" ; 
    plan1SubscriptionCount = 0 ;
    var percentage1 = 0  ; 
}

if (plan2Name == null && plan2SubscriptionCount == null ){ 
    plan2Name = "plan2" ; 
    plan2SubscriptionCount = 0 ;
    var percentage2 = 0  ; 
}


console.log('Plan 1 Name:', plan1Name);
console.log('Plan 1 Subscription Count:', plan1SubscriptionCount);

console.log('Plan 2 Name:', plan2Name);
console.log('Plan 2 Subscription Count:', plan2SubscriptionCount);

console.log('Plan 3 Name:', plan3Name);
console.log('Plan 3 Subscription Count:', plan3SubscriptionCount);


var sum = parseInt(plan1SubscriptionCount)+ parseInt(plan2SubscriptionCount)+parseInt(plan3SubscriptionCount)

var percentage1 = (parseInt(plan1SubscriptionCount)/sum)*100  ; 

var percentage2 = (parseInt(plan2SubscriptionCount)/sum)*100 ;

var percentage3 = (parseInt(plan3SubscriptionCount)/sum)*100  ; 


console.log(percentage1) ;
console.log(percentage2) ;
console.log(percentage3) ;


var options = {
  series: [{
      name: plan1Name,
      data: [30, 12, 7, 20, 55, 10, 20, 40, 60, 78, Math.round(percentage1), 0]
  }, {
      name: plan2Name,
      data: [20, 44, 20, 55, 20, 12, 50, 10, 70, 44, Math.round(percentage2), 0]
  }, {
      name: plan3Name,
      data: [50, 20, 30, 69, 10, 11, 10, 20, 80, 20, Math.round(percentage3), 0]
  }],
  chart: {
      type: 'bar',
      height: 350
  },
  plotOptions: {
      bar: {
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
      },
  },
  dataLabels: {
      enabled: false
  },
  stroke: {
      show: true,
      width: 2,
      colors: ['transparent']
  },
  xaxis: {
      categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep' , 'Oct', 'Nov' , 'Dec'],
      labels: {
          style: {
              colors: '#fff' // Set x-axis label color to white
          }
      }
  },
  yaxis: {
      title: {
          text: 'Percentage',
          style: {
              color: '#fff' // Set y-axis title color to white
          }
      },
      labels: {
          style: {
              colors: '#fff' // Set y-axis label color to white
          }
      }
  },
  fill: {
      opacity: 1
  },
  tooltip: {
      y: {
          formatter: function () {
          }
      }
  },
  legend: {
      labels: {
          colors: '#fff' // Set series name font color to white
      },
      show: true,
      position: 'top',
  },
  colors: ['#583cb3', '#d50000', '#2fa735'], // Set the series colors to white
};

var chart = new ApexCharts(document.querySelector("#sales-chart"), options);
chart.render();
