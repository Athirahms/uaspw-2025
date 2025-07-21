<!-- Book A Table Section -->
    <section id="book-a-table" class="book-a-table section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-5 mb-5">
          <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
            <div class="reservation-info">
              <div class="text-content">
                <h3>Book Your Table</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo. Aliquam erat volutpat.</p>

                <div class="reservation-details mt-4">
                  <div class="detail-item">
                    <i class="bi bi-clock"></i>
                    <div>
                      <h5>Opening Hours</h5>
                      <p>Monday - Friday: 11:00 AM - 11:00 PM<br>
                        Saturday - Sunday: 10:00 AM - 12:00 AM</p>
                    </div>
                  </div>

                  <div class="detail-item">
                    <i class="bi bi-geo-alt"></i>
                    <div>
                      <h5>Location</h5>
                      <p>1234 Main Street, Suite 100<br>
                        Boston, MA 02110</p>
                    </div>
                  </div>

                  <div class="detail-item">
                    <i class="bi bi-telephone"></i>
                    <div>
                      <h5>Call Us</h5>
                      <p>+1 (617) 555-1234</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
            <div class="reservation-image">
              <img src="public/front/assets/img/restaurant/showcase-7.webp" alt="Restaurant interior" class="img-fluid rounded">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12" data-aos="fade-up" data-aos-delay="400">
            <div class="reservation-form-wrapper">
              <div class="form-header">
                <h3>Book A Table</h3>
                <p>Please fill the form below to make a reservation</p>
              </div>

              <form action="forms/book-a-table.php" method="post" role="form" class="php-email-form mt-4">
                <table class="table">
                <thead>
                    <tr>
                    <th>Nama</th><th>Email</th><th>Nomor Telepon</th><th>Hari</th><th>Waktu</th><th>Jumlah Tamu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations ?? [] as $res)
                    <tr>
                        <td>{{ $res->nama_pelanggan }}</td>
                        <td>{{ $res->email }}</td>
                        <td>{{ $res->nomor_telepon }}</td>
                        <td>{{ $res->hari }}</td>
                        <td>{{ $res->waktu }}</td>
                        <td>{{ $res->julah_tamu }}</td>
                        <td>{{ $res->menu_id }}</td>
                    </tr>
                    @endforeach
                </tbody>
                </table>


                <div class="my-3">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your booking request was sent. We will call back or send an Email to confirm your reservation. Thank you!</div>
                </div>

                <div class="text-center mt-4">
                  <button type="submit" class="btn-book-table">Book Now</button>
                </div>
              </form>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /Book A Table Section -->
