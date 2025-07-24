<!DOCTYPE html>
<html>
<head>
  <title>Robot Arm Control Panel</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Robot Arm Control Panel</h1>

<div class="controller">
  <div class="sliders">
    <?php for ($i = 1; $i <= 6; $i++): ?>
      <div>
        <label>Servo <?= $i ?>:</label>
        <input type="range" id="servo<?= $i ?>" min="0" max="180" value="90" oninput="updateLabel(<?= $i ?>)">
        <span id="label<?= $i ?>">90</span>
      </div>
    <?php endfor; ?>
  </div>

  <div class="button-group">
    <button onclick="savePose()">Save Pose</button>
    <button onclick="resetPose()">Reset</button>
    <button onclick="loadLatestPose()">Run</button>
  </div>
</div>

<h2>Saved Poses</h2>
<table>
  
  <tbody id="poseTable"></tbody>
</table>

<script src="script.js?v=2"></script> <!-- force refresh -->
</body>
</html>
