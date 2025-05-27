let currentPage = 1;

const updatePagination = (newPage) => {
  currentPage = newPage;

  // Update tampilan pagination
  document.querySelectorAll(".page-item").forEach(item => item.classList.remove("active"));
  document.querySelector(`.page-link[data-page="${newPage}"]`)?.parentElement.classList.add("active");

  // Tampilkan konten berdasarkan halaman
  console.log("Menampilkan halaman:", newPage);

  // TODO: Tambahkan logika menampilkan produk halaman ini
};

// Klik angka halaman
document.querySelectorAll(".page-link[data-page]").forEach(link => {
  link.addEventListener("click", function (e) {
    e.preventDefault();
    const page = parseInt(this.getAttribute("data-page"));
    updatePagination(page);
  });
});

// Klik tombol Next
document.getElementById("next-page")?.addEventListener("click", function (e) {
  e.preventDefault();
  const totalPages = 3;
  if (currentPage < totalPages) {
    updatePagination(currentPage + 1);
  }
});
