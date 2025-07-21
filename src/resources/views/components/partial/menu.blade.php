<!-- Menu Section -->
    <section id="menu" class="menu section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Menu</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up">

        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

          <div class="menu-filters isotope-filters mb-5">
            <ul>
              <li data-filter="*" class="filter-active">All</li>
              <li data-filter=".filter-makanan">Makanan</li>
              <li data-filter=".filter-dessert">Desserts</li>
              <li data-filter=".filter-minuman">Minuman</li>
            </ul>
          </div>

          <div class="menu-container isotope-container row gy-4">

            <!-- Regular Menu Items -->

           @foreach($items ?? [] as $item)
            <div class="col-lg-6 isotope-item filter-{{ $item->category }}">
              <div class="d-flex menu-item align-items-center gap-4">
                @if($item->image)
                  <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" class="menu-img img-fluid rounded-3">
                @endif
                <div class="menu-content">
                  <h5>
                    {{ $item->name }}
                  </h5>
                  <p>{{ $item->description }}</p>
                  <div class="price">${{ number_format($item->price, 2) }}</div>
                </div>
              </div>
            </div>
            @endforeach

          </div>

        </div>

        <div class="text-center mt-5" data-aos="fade-up">
          <a href="#" class="download-menu">
            <i class="bi bi-file-earmark-pdf"></i> Download Full Menu
          </a>
        </div>

        <!-- Chef's Specials -->
        <div class="col-12 mt-5" data-aos="fade-up">
          <div class="specials-badge">
            <span><i class="bi bi-award"></i> Chef's Specials</span>
          </div>
          <div class="specials-container">
            <div class="row g-4">
              <div class="col-md-6">
                <div class="menu-item special-item">
                  <div class="menu-item-img">
                    <img src="public/front/assets/img/restaurant/main-3.webp" alt="Special Dish" class="img-fluid">
                    <div class="menu-item-badges">
                      <span class="badge-special">Special</span>
                      <span class="badge-vegan">Vegan</span>
                    </div>
                  </div>
                  <div class="menu-item-content">
                    <h4>Mediterranean Grilled Salmon</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ut aliquam metus. Vivamus fermentum magna quis.</p>
                    <div class="menu-item-price">$24.99</div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="menu-item special-item">
                  <div class="menu-item-img">
                    <img src="public/front/assets/img/restaurant/main-7.webp" alt="Special Dish" class="img-fluid">
                    <div class="menu-item-badges">
                      <span class="badge-special">Special</span>
                      <span class="badge-spicy">Spicy</span>
                    </div>
                  </div>
                  <div class="menu-item-content">
                    <h4>Signature Ribeye Steak</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam accumsan risus ut dui pretium, eget elementum nisi.</p>
                    <div class="menu-item-price">$32.99</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /Menu Section -->