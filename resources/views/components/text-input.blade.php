@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'flex h-10 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm placeholder:text-slate-400 focus:outline-none focus:border-brand-indigo-500 focus:ring-4 focus:ring-brand-indigo-500/20 disabled:cursor-not-allowed disabled:opacity-50 transition-shadow']) }}>
