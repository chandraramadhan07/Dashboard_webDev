var canvasElement = document.getElementById("cookieChart");
var config = {
  type: "bar",
  data: {
    labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus"],
    datasets: [
      {
        label: "Masuk",
        data: [500, 120, 300, 700, 500, 450, 390, 450, 250],
      },
      {
        label: "Keluar",
        data: [490, 65, 128, 500, 100, 200, 150, 79, 100],
      },
    ],
  },
  option: {
    responsive: true,
    scales: {
      x: {
        stacked: false,
      },
      y: {
        beginAtZero: true,
      },
    },
  },
};

var cookieChart = new Chart(canvasElement, config);
