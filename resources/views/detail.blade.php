<x-layout></x-layout>
  <x-dashboard></x-dashboard>
  <div class="pt-16">
    <div class="mx-auto grid max-w-7xl grid-cols-2 items-center gap-x-8 px-4 py-24 sm:px-6 sm:py-32 lg:px-8">
      <div>
        <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ $isiDetail['nama'] }}</h2>
        <p class="mt-4 text-gray-500">
          {{ $isiDetail->created_at->diffForHumans() }}
        </p>

        <p class="mt-4 text-gray-500">
          {{ $isiDetail['deskripsi'] }}
        </p>
        <div class="mt-5 flex gap-x-6">
          <a href="/home" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Kembali &laquo;</a>
        </div>
      </div>
      <div>
        <img
          src="https://tailwindui.com/plus/img/ecommerce-images/product-feature-03-detail-01.jpg"
          alt="Walnut card tray with white powder-coated steel divider and 3 punchout holes."
          class="rounded-lg bg-gray-100 w-full"
        />
      </div>
    </div>
  </div>

  
  
