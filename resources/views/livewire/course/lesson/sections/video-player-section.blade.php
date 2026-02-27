<!-- Video Player Section -->
<div class="bg-black rounded-lg overflow-hidden mb-6">
    <div
        class="plyr__video-embed"
        id="plyr-player"
    >
        @if ($lesson->video_url)
            <video
                id="video-player"
                data-poster="{{ Vite::Image('video-placeholder.jpg') }}"
                controls
                crossorigin
                playsinline
            >
                <source
                    src="{{ $lesson->video_url }}"
                    type="video/mp4"
                />
                Your browser does not support the video tag.
            </video>
        @else
            <div class="aspect-video flex items-center justify-center bg-gray-900">
                <div class="text-center text-white">
                    <svg
                        class="w-16 h-16 mx-auto mb-4 opacity-50"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"
                        ></path>
                    </svg>
                    <p class="text-lg font-medium">No video available</p>
                    <p class="text-sm opacity-75 mt-1">Video content will be available soon</p>
                </div>
            </div>
        @endif
    </div>
</div>
