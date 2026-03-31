<x-mail::message>
# مرحباً {{ $customer->name }}

شكراً لتسجيلك في موقعنا {{ config('app.name') }}. نحن سعداء بانضمامك إلينا!

<x-mail::button :url="route('home')">
تصفح السيارات
</x-mail::button>

مع تحياتنا،<br>
فريق {{ config('app.name') }}
</x-mail::message>
