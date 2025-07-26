<!-- File Preview -->
<div id="file-preview" class="hidden mb-4">
    <div class="bg-[#1a1a1a] border border-[#333333] rounded-xl p-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-[#5b6df0] rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div>
                <p id="file-name" class="text-sm font-medium text-[#e5e5e5]"></p>
                <p id="file-size" class="text-xs text-[#a3a3a3]"></p>
            </div>
        </div>
        <button type="button" onclick="removeFile()" class="p-1.5 text-[#a3a3a3] hover:text-[#e5e5e5] hover:bg-[#262626] rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>