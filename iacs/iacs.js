/**
 * IACS – Institute of Applied CX Science
 * Shared JavaScript v1.0
 */

document.addEventListener("DOMContentLoaded", () => {
  // ── Sticky Header & Scroll Progress ────────────────────────
  const header = document.getElementById("site-header");
  const scrollBar = document.getElementById("scroll-bar");
  if (header) {
    const onScroll = () => {
      // Sticky header
      if (window.scrollY > 40) {
        header.classList.add("scrolled");
      } else {
        header.classList.remove("scrolled");
      }

      // Progress Bar
      if (scrollBar) {
        const winScroll =
          document.body.scrollTop || document.documentElement.scrollTop;
        const height =
          document.documentElement.scrollHeight -
          document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        scrollBar.style.width = scrolled + "%";
      }
    };
    window.addEventListener("scroll", onScroll, { passive: true });
    onScroll();
  }

  // ── Mobile Nav Toggle ──────────────────────────────────────
  const navToggles = document.querySelectorAll(".nav-toggle");
  const navMobile = document.getElementById("nav-mobile");
  if (navToggles.length > 0 && navMobile) {
    navToggles.forEach((toggle) => {
      toggle.addEventListener("click", () => {
        const isOpen = navMobile.classList.toggle("open");
        navToggles.forEach((t) => t.classList.toggle("open", isOpen));
        navToggles.forEach((t) => t.setAttribute("aria-expanded", isOpen));
        document.body.style.overflow = isOpen ? "hidden" : "";
      });
    });
    // Close on link click
    navMobile.querySelectorAll("a").forEach((a) => {
      a.addEventListener("click", () => {
        navMobile.classList.remove("open");
        navToggles.forEach((t) => t.classList.remove("open"));
        document.body.style.overflow = "";
      });
    });
  }

  // ── Active nav link ────────────────────────────────────────
  const currentPage = location.pathname.split("/").pop() || "index.html";
  document.querySelectorAll(".nav-link").forEach((link) => {
    const href = link.getAttribute("href") || "";
    if (href === currentPage || (currentPage === "" && href === "index.html")) {
      link.classList.add("active");
    }
  });

  // ── Financial Control Grid (Homepage) ─────────────────────
  const fcgQuadrants = document.querySelectorAll(".fcg-quadrant");
  fcgQuadrants.forEach((q) => {
    const type = q.dataset.type; // 'danger' or 'engine'
    q.addEventListener("mouseenter", () => {
      if (type === "danger") q.classList.add("is-danger");
      if (type === "engine") q.classList.add("is-engine");
    });
    q.addEventListener("mouseleave", () => {
      q.classList.remove("is-danger", "is-engine");
    });
  });

  // ── Accordion ──────────────────────────────────────────────
  const triggers = document.querySelectorAll(".accordion-trigger");
  triggers.forEach((trigger) => {
    trigger.addEventListener("click", () => {
      const body = trigger.nextElementSibling;
      const isOpen = trigger.classList.contains("open");

      // Close all
      triggers.forEach((t) => {
        t.classList.remove("open");
        const b = t.nextElementSibling;
        if (b) {
          b.classList.remove("open");
        }
      });

      // Toggle clicked
      if (!isOpen) {
        trigger.classList.add("open");
        if (body) body.classList.add("open");
      }
    });
  });

  // ── Verify Page ────────────────────────────────────────────
  const verifyForm = document.getElementById("verify-form");
  if (verifyForm) {
    const MOCK_CREDENTIALS = {
      "CGVS-2024-001": { name: "Ahmad Samir", date: "15 January 2024" },
      "CGVS-2025-042": { name: "Sarah Mitchell", date: "03 March 2025" },
      "CGVS-2025-099": { name: "James Okafor", date: "22 June 2025" },
    };

    verifyForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const input = document.getElementById("credential-input");
      const resultBox = document.getElementById("verify-result");
      const statusEl = document.getElementById("verify-status");
      const detailEl = document.getElementById("verify-detail");
      if (!input || !resultBox) return;

      const id = input.value.trim().toUpperCase();
      const cred = MOCK_CREDENTIALS[id];

      resultBox.className = "verify-result";
      if (cred) {
        resultBox.classList.add("verified");
        statusEl.textContent = `STATUS: VERIFIED. Issued to ${cred.name}. Date: ${cred.date}.`;
        statusEl.className = "verify-status ok";
        detailEl.innerHTML = `
          Credential ID: <strong>${id}</strong><br>
          Designation: <strong>Certified GenAI Value Strategist (CGVS™)</strong><br>
          Certifying Body: <strong>Institute of Applied CX Science Registry</strong>
        `;
      } else {
        resultBox.classList.add("not-found");
        statusEl.textContent = "✗  STATUS: NOT FOUND";
        statusEl.className = "verify-status fail";
        detailEl.innerHTML = `No credential matching <strong>${id}</strong> was found in the IACS registry. Please verify the ID and try again, or contact <a href="mailto:chairman@appliedcxscience.com" style="color:var(--gold)">chairman@appliedcxscience.com</a>.`;
      }
    });
  }

  // ── Library email gate ────────────────────────────────────
  document.querySelectorAll(".btn-download-abstract").forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      const email = window.prompt(
        "Enter your institutional email address to access this Intelligence Briefing:",
      );
      if (email && email.includes("@")) {
        alert(
          `Thank you. The abstract for "${btn.dataset.title}" has been sent to ${email}.`,
        );
      } else if (email !== null) {
        alert("Please enter a valid email address.");
      }
    });
  });

  // ── Intersection Observer: sharp terminal-snap reveal ──────
  // Rule: No bounce, no soft ease. State cuts from hidden to visible.
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          // Hard state switch — like data populating on a terminal screen
          entry.target.style.opacity = "1";
          entry.target.style.transform = "none";
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.08 },
  );

  document.querySelectorAll(".reveal").forEach((el) => {
    el.style.opacity = "0";
    el.style.transform = "translateY(6px)";
    // Sharp linear transition — not cubic-bezier, not ease-in-out
    el.style.transition = "opacity 120ms linear, transform 120ms linear";
    observer.observe(el);
  });

  // --- FCG INTERACTION ---
  document.querySelectorAll(".fcg-quadrant").forEach((quad) => {
    quad.addEventListener("mouseenter", () => {
      const type = quad.getAttribute("data-type");
      if (type === "danger") quad.classList.add("is-danger");
      if (type === "engine") quad.classList.add("is-engine");
    });
    quad.addEventListener("mouseleave", () => {
      quad.classList.remove("is-danger", "is-engine");
    });
  });

  // ── Custom Cursor Follower ────────────────────────────────
  const cursor = document.getElementById("cursor-follower");
  if (cursor) {
    document.addEventListener("mousemove", (e) => {
      cursor.style.left = e.clientX + "px";
      cursor.style.top = e.clientY + "px";
    });

    document
      .querySelectorAll("a, button, .hero-card, .calc-input")
      .forEach((el) => {
        el.addEventListener("mouseenter", () =>
          cursor.classList.add("hovering"),
        );
        el.addEventListener("mouseleave", () =>
          cursor.classList.remove("hovering"),
        );
      });
  }
});

// ── Solvency Calculator Logic ──────────────────────────────
function calculateSolvency() {
  const rev = parseFloat(document.getElementById("revenue-input").value) || 0;
  const fric =
    parseFloat(document.getElementById("friction-range").value) || 30;
  const churn = parseFloat(document.getElementById("churn-input").value) || 0;

  // Formula: Friction Loss = Revenue * (Friction/250) + (Revenue * Churn/100 * 0.5)
  // This is a simplified forensic model for demonstration
  const frictionFactor = fric / 200;
  const churnFactor = churn / 100;

  const loss = rev * frictionFactor + rev * churnFactor * 0.8;
  const tsScore = Math.max(0, Math.min(100, 100 - fric * 0.6 - churn * 1.2));

  // Update UI with animation
  const lossEl = document.getElementById("friction-loss-val");
  const scoreEl = document.getElementById("solvency-score-val");

  if (lossEl) lossEl.textContent = `$${loss.toFixed(2)}M`;
  if (scoreEl) scoreEl.textContent = `${Math.round(tsScore)}%`;

  // Color coding: gold = healthy, red = critical. NO pure green per spec.
  if (scoreEl) {
    if (tsScore < 40) scoreEl.style.color = "var(--red)";
    else if (tsScore < 70) scoreEl.style.color = "var(--gold)";
    else scoreEl.style.color = "var(--cream)"; // Clean pass = off-white, not green
  }
}
