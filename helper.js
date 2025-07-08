const sidebar = document.getElementById("sidebar");
const topbar = document.getElementById("topbar");

function toggleSidebar() {
  if (sidebar.classList.contains("d-none")) {
    sidebar.classList.remove("d-none");
    topbar.classList.remove("col-md-12");
    topbar.classList.add("col-md-10");
  } else {
    sidebar.classList.add("d-none");
    topbar.classList.remove("col-md-10");
    topbar.classList.add("col-md-12");
  }
}
