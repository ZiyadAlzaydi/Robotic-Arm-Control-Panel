function updateLabel(n) {
  const val = document.getElementById("servo" + n).value;
  document.getElementById("label" + n).innerText = val;
}

function savePose() {
  let data = [];
  for (let i = 1; i <= 6; i++) {
    data.push(document.getElementById("servo" + i).value);
  }

  fetch("save_pose.php", {
    method: "POST",
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ servos: data })
  })
    .then(res => res.text())
    .then(msg => {
      alert(msg);
      loadTable();
    });
}

function loadPose(id) {
  fetch(`load_pose.php?id=${id}`)
    .then(res => res.json())
    .then(data => {
      for (let i = 1; i <= 6; i++) {
        document.getElementById("servo" + i).value = data[`servo${i}`];
        updateLabel(i);
      }
      fetch("update_status.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
      });
    });
}

function removePose(id) {
  if (!confirm("Are you sure you want to delete this pose?")) return;

  fetch('delete_pose.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: 'id=' + id
  })
  .then(res => res.text())
  .then(response => {
    alert(response);
    // Force reload the table data from server
    loadTable();
  })
  .catch(err => {
    console.error('Error deleting:', err);
    alert('Error deleting pose: ' + err);
  });
}


function loadTable() {
  fetch("get_run_pose.php")
    .then(res => res.json())
    .then(data => {
      let html = `
        <table border="1" cellpadding="5">
          <tr>
            <th>#</th><th>Servo1</th><th>Servo2</th><th>Servo3</th>
            <th>Servo4</th><th>Servo5</th><th>Servo6</th><th>Actions</th>
          </tr>
      `;
      
      data.forEach((row) => {
        // Ensure we have a valid ID
        const id = row.id || 'N/A'; // Fallback if ID is missing
        
        html += `
          <tr>
            <td>${id}</td>
            <td>${row.servo1}</td>
            <td>${row.servo2}</td>
            <td>${row.servo3}</td>
            <td>${row.servo4}</td>
            <td>${row.servo5}</td>
            <td>${row.servo6}</td>
            <td>
  <button onclick="loadPose(${row.id})">Load</button>
  <button onclick="removePose(${row.id})">Delete</button>
</td>


          </tr>`;
      });
      
      html += `</table>`;
      document.getElementById("poseTable").innerHTML = html;
    })
    .catch(error => {
      console.error("Error loading poses:", error);
      document.getElementById("poseTable").innerHTML = "<p>Error loading poses</p>";
    });
}

function resetPose() {
  for (let i = 1; i <= 6; i++) {
    document.getElementById("servo" + i).value = 90;
    updateLabel(i);
  }
}

function loadLatestPose() {
  fetch("get_run_pose.php")
    .then(res => res.json())
    .then(data => {
      if (data.length === 0) return alert("No poses found.");
      let latest = data[data.length - 1];
      for (let i = 1; i <= 6; i++) {
        document.getElementById("servo" + i).value = latest["servo" + i];
        updateLabel(i);
      }
      fetch("update_status.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(latest)
      });
    });
}

window.onload = loadTable;
