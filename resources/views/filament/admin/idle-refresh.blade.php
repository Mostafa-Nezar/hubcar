@php
    // To enforce admin logout after 1 minute of no *user interaction*, we POST to the panel logout endpoint.
     $idleMs = 7 * 24 * 60 * 60 * 1000; // 1 week
@endphp

<script>
  (() => {
    const idleMs = {{ $idleMs }};
    const timeoutMs = idleMs + 2000; // small buffer to avoid edge timing issues

    let timerId = null;

    const reset = () => {
      if (timerId) clearTimeout(timerId);
      timerId = setTimeout(() => {
        const token =
          document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
          '{{ csrf_token() }}';

        // Filament panel default logout endpoint:
        // POST /admin/logout
        fetch('/admin/logout', {
          method: 'POST',
          credentials: 'same-origin',
          headers: {
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
          },
        }).finally(() => {
          window.location.href = '/admin/login';
        });
      }, timeoutMs);
    };

    ['mousemove', 'mousedown', 'keydown', 'scroll', 'touchstart'].forEach((event) => {
      window.addEventListener(event, reset, { passive: true });
    });

    reset();
  })();
</script>

