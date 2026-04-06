<button {{ $attributes->merge(['type' => 'submit', 'class' => 'sur-btn-primary min-h-11 px-6 text-sm font-semibold disabled:cursor-not-allowed disabled:opacity-50']) }}>
    {{ $slot }}
</button>
