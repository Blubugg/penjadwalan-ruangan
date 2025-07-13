<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full text-white bg-[#000080] hover:bg-[#1a1a99] focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"']) }}>
    {{ $slot }}
</button>
