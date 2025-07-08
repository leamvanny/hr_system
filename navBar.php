

<?php

echo '
<div class="d-flex align-items-center justify-content-between w-100 bg-white p-3">
    <div style="cursor: pointer;">
        <span id="toggleSidebarBtn">
            <i class="fa-solid fa-bars"></i>
        </span>
    </div>
    <div class="px-3 py-2 bg-info rounded">P</div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
  const toggleBtn = document.getElementById("toggleSidebarBtn");
  const sidebar = document.getElementById("sidebar");
  const topbar = document.getElementById("topbar");

  toggleBtn.addEventListener("click", () => {
    if (sidebar.style.display === "none") {
      // Show sidebar, shrink topbar
      sidebar.style.display = "";
      topbar.classList.remove("col-md-12");
      topbar.classList.add("col-md-10");
    } else {
      // Hide sidebar, topbar full width
      sidebar.style.display = "none";
      topbar.classList.remove("col-md-10");
      topbar.classList.add("col-md-12");
    }
  });
});
</script>
';
?>