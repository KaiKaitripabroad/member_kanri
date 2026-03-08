<x-app-layout>
    <div x-data="{ 
        search: '', 
        tab: 'all',
        members: {{ $allMembers->toJson() }} 
    }" class="py-8 px-6 pb-24">

        <header class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">メンバー一覧</h1>
        </header>

        <div class="mb-6">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                    <i class="fas fa-search"></i>
                </span>
                <input
                    type="text"
                    x-model="search"
                    class="block w-full pl-12 pr-4 py-4 border-none bg-gray-100 rounded-2xl focus:ring-2 focus:ring-blue-500 text-lg placeholder-gray-400"
                    placeholder="名前・学籍番号で検索...">
            </div>
        </div>

        <div class="mb-8 flex space-x-3 overflow-x-auto no-scrollbar">
            <button
                @click="tab = 'all'"
                :class="tab === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-500'"
                class="px-6 py-2 rounded-full text-sm font-bold whitespace-nowrap transition-colors">
                全員 ({{ $allMembers->count() }})
            </button>
            <button
                @click="tab = 'new'"
                :class="tab === 'new' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-500'"
                class="px-6 py-2 rounded-full text-sm font-bold whitespace-nowrap transition-colors">
                今月の加入
            </button>
        </div>

        <div class="space-y-4">
            <template x-for="member in members" :key="member.id">
                <a
                    :href="'/members/' + member.id"
                    x-show="(tab === 'all' || (tab === 'new' && new Date(member.created_at).getMonth() === new Date().getMonth())) && 
                            (member.name.toLowerCase().includes(search.toLowerCase()) || 
                             (member.student_number && member.student_number.toString().includes(search)))"
                    class="flex items-center p-5 bg-white border border-gray-100 rounded-3xl shadow-sm hover:shadow-md transition-shadow cursor-pointer no-underline text-inherit">
                    <div class="w-14 h-14 rounded-full flex items-center justify-center text-white font-bold mr-5 text-xl bg-indigo-500 overflow-hidden">
                        <template x-if="member.photo">
                            <img :src="'/storage/' + member.photo" class="w-full h-full object-contain" alt="">
                        </template>

                        <template x-if="!member.photo">
                            <span x-text="member.name.substring(0, 1)"></span>
                        </template>
                    </div>

                    <div class="flex-grow">
                        <div class="text-lg font-bold text-gray-900" x-text="member.name"></div>
                        <template x-if="member.student_number">
                            <div class="text-xs text-gray-500" x-text="'学籍番号: ' + member.student_number"></div>
                        </template>
                        <div class="text-xs text-gray-400" x-text="member.email"></div>
                    </div>

                    <div class="text-gray-200">
                        <i class="fas fa-chevron-right text-sm"></i>
                    </div>
                </a>
            </template>

            <div x-show="members.filter(m => (tab === 'all' || (tab === 'new' && new Date(m.created_at).getMonth() === new Date().getMonth())) && (m.name.toLowerCase().includes(search.toLowerCase()) || (m.student_number && m.student_number.toString().includes(search)))).length === 0"
                class="text-center py-10 text-gray-400">
                該当するメンバーが見つかりません
            </div>
        </div>
    </div>

    @include('components.bottom-nav')

    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</x-app-layout>