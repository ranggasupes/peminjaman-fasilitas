document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.getElementById("menuToggle");
    const sidebar = document.getElementById("sidebar");

    if (menuToggle && sidebar) {
        menuToggle.addEventListener("click", function () {
            sidebar.classList.toggle("open");
        });

        document.addEventListener("click", function (event) {
            if (
                window.innerWidth <= 760 &&
                sidebar.classList.contains("open") &&
                !sidebar.contains(event.target) &&
                !menuToggle.contains(event.target)
            ) {
                sidebar.classList.remove("open");
            }
        });
    }

    const currentDate = document.getElementById("currentDate");

    if (currentDate) {
        currentDate.textContent = new Intl.DateTimeFormat("id-ID", {
            weekday: "long",
            day: "numeric",
            month: "long",
            year: "numeric",
        }).format(new Date());
    }

    document.querySelectorAll(".alert-close").forEach(function (button) {
        button.addEventListener("click", function () {
            const alert = button.closest(".alert");

            if (alert) {
                alert.remove();
            }
        });
    });

    document.querySelectorAll("[data-confirm]").forEach(function (element) {
        element.addEventListener("click", function (event) {
            const message = element.getAttribute("data-confirm");

            if (!window.confirm(message || "Apakah Anda yakin?")) {
                event.preventDefault();
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Navbar responsif untuk dashboard peminjam
    const navToggle = document.getElementById("navToggle");
    const userNav = document.getElementById("userNav");

    if (navToggle && userNav) {
        navToggle.addEventListener("click", function () {
            const isOpen = userNav.classList.toggle("is-open");
            navToggle.setAttribute("aria-expanded", String(isOpen));
            navToggle.textContent = isOpen ? "✕" : "☰";
        });

        userNav.querySelectorAll("a").forEach(function (link) {
            link.addEventListener("click", function () {
                userNav.classList.remove("is-open");
                navToggle.setAttribute("aria-expanded", "false");
                navToggle.textContent = "☰";
            });
        });
    }

    // Pencarian fasilitas yang tersedia
    const searchForm = document.getElementById("facilitySearch");
    const searchInput = document.getElementById("facilitySearchInput");
    const searchEmpty = document.getElementById("searchEmpty");

    if (searchForm && searchInput) {
        searchForm.addEventListener("submit", function (event) {
            event.preventDefault();

            const keyword = searchInput.value.trim().toLowerCase();
            const cards = document.querySelectorAll(".facility-card");
            let visibleCount = 0;

            cards.forEach(function (card) {
                const name = card.dataset.facilityName || "";
                const visible = name.includes(keyword);

                card.hidden = !visible;

                if (visible) {
                    visibleCount++;
                }
            });

            if (searchEmpty) {
                searchEmpty.hidden = visibleCount !== 0;
            }

            const facilitySection = document.getElementById("fasilitas");

            if (facilitySection) {
                facilitySection.scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                });
            }
        });

        searchInput.addEventListener("input", function () {
            if (searchInput.value.trim() === "") {
                document
                    .querySelectorAll(".facility-card")
                    .forEach(function (card) {
                        card.hidden = false;
                    });

                if (searchEmpty) {
                    searchEmpty.hidden = true;
                }
            }
        });
    }
});

/* =========================================
   FASILITASKU - DASHBOARD PEMINJAM
   File: public/js/app.js
========================================= */

document.addEventListener("DOMContentLoaded", function () {
    const searchForm = document.getElementById("facility-search-form");
    const searchInput = document.getElementById("facility-search");
    const facilityCards = document.querySelectorAll(".user-facility-card");
    const emptyMessage = document.getElementById("facility-search-empty");

    // Pencarian fasilitas
    function filterFacilities() {
        if (!searchInput || !emptyMessage) return;

        const keyword = searchInput.value.toLowerCase().trim();
        let visibleCount = 0;

        facilityCards.forEach(function (card) {
            const searchableText = card.dataset.facilityName || "";
            const matched = searchableText.includes(keyword);

            card.hidden = !matched;

            if (matched) {
                visibleCount++;
            }
        });

        emptyMessage.hidden = visibleCount > 0;
    }

    if (searchForm && searchInput) {
        searchForm.addEventListener("submit", function (event) {
            event.preventDefault();

            filterFacilities();

            const facilitySection = document.getElementById("fasilitas");

            if (facilitySection) {
                facilitySection.scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                });
            }
        });

        searchInput.addEventListener("input", filterFacilities);
    }

    // Peta interaktif
    const mapElement = document.getElementById("user-facility-map");

    if (mapElement && typeof L !== "undefined") {
        const paluCoordinates = [-0.8917, 119.8707];

        const map = L.map(mapElement).setView(paluCoordinates, 12);

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution:
                '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            maxZoom: 19,
        }).addTo(map);

        L.marker(paluCoordinates)
            .addTo(map)
            .bindPopup("<strong>Kota Palu</strong><br>Pusat peta fasilitas.");

        // Simpan instance agar dapat diperluas ketika koordinat fasilitas tersedia.
        window.fasilitaskuMap = map;

        // Memperbaiki ukuran peta ketika layout selesai ditampilkan.
        setTimeout(function () {
            map.invalidateSize();
        }, 250);
    }
});
