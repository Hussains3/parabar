<section>
    <div class="mx-auto container px-4 py-4 flex flex-col sm:flex-row gap-4">
        <div class="basis-4/5">
            <!-- Carousel Container -->
            <div class="carousel-container rounded-md">

                {{-- Slide one --}}
                <div class="carousel-slide active">
                    <img src="{{asset('images/herobg1.jpg')}}" alt="Slide 1" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col items-center justify-center text-center px-6">
                        
                    </div>
                </div>
                {{-- Slide one --}}
                <div class="carousel-slide">
                    <img src="{{asset('images/herobg2.jpg')}}" alt="Slide 2" class="w-full h-full object-cover">
                </div>
                {{-- Slide one --}}
                <div class="carousel-slide">
                    <img src="https://picsum.photos/1200/600?random=3" alt="Slide 3" class="w-full h-full object-cover">
                </div>

                <!-- Carousel Controls -->
                <div class="carousel-btn prev-btn">❮</div>
                <div class="carousel-btn next-btn">❯</div>

                <div class="carousel-bullets">
                    <div class="bullet active" data-slide="0"></div>
                    <div class="bullet" data-slide="1"></div>
                    <div class="bullet" data-slide="2"></div>
                </div>
            </div>
        </div>
        <div class="card px-2 w-60 flex justify-between flex-col flex-grow">
            <div   class="block text-center px-4 py-2 bg-white shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all w-full font-bold text-lg" href="">
                <img src="{{ asset('images/President.jpg') }}" alt="President" class="full h-auto">
                <div class="text-center text-lg font-bold text-gray-800 py-4">
                    President
                </div>
            </div>
            <div   class="block text-center px-4 py-2 bg-white shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all w-full font-bold text-lg" href="">
                <img src="{{ asset('images/General Secretary.jpg') }}" alt="General Secretary" class="full h-auto">
                <div class="text-center text-lg font-bold text-gray-800 py-4">
                    General Secretary
                </div>
            </div>
        </div>
    </div>
</section>


