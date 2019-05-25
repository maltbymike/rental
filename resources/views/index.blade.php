@extends('layouts.newapp')

@section('title', 'Ingersoll Rent-All')

@section('content')
  <header>
    <div id="homepageSlider" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        @foreach($images as $image)
          @if($loop->first)
            <li data-target="#homepageSlider" data-slide-to="0" class="active"></li>
          @else
            <li data-target="#homepageSlider" data-slide-to="{{ $loop->index }}"></li>
          @endif
        @endforeach
      </ol>

      <div class="carousel-inner" role="listbox">
        @foreach($images as $image)
          <div class="carousel-item {{ $loop->first ? 'active' : '' }}" style="background-image: url({{ asset('/storage/images/' . $image->filename) }})">
            @if ($image->title OR $image->caption OR $image->link_to)
              <div class="carousel-caption d-none d-block rounded" style="background-color: rgba(0, 0, 0, .7)">
                @if ($image->title)
                  <h3 class="text-primary">{{ $image->title }}</h3>
                @endif
                @if ($image->caption)
                  <p>{{ $image->caption }}</p>
                @endif
                @if ($image->link_to)
                  <a href="{{ $image->link_to }}" class="btn btn-primary">{{ $image->button_text }}</a>
                @endif
              </div>
            @endif
          </div>
        @endforeach
      </div>

      <a class="carousel-control-prev" href="#homepageSlider" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>

      <a class="carousel-control-next" href="#homepageSlider" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>

    </div>
  </header>

  <!-- Page Content -->
  <div class="container-fluid bg-secondary page-section">
    <div class="container">
      <div class="py-4 lead text-justify text-white">
        <p>Ingersoll Rent-All is the leading independent supplier of rental equipment and contractor supplies in Oxford County. From our headquarters in Ingersoll, Ontario we proudly serve the residents, contractors, landscapers, municipalities, farmers, and factories of Ingersoll, Woodstock, Tillsonburg, Dorchester, Thamesford, Tavistock and everywhere in between.</p>
        <p>Canadian Owned and 100% Independent, we have been serving our community since 1986 with competitively priced, well maintained, quality late model rental equipment and professional grade tools & accessories.</p>
        <p>We truly have Everything... and what you might need!</p>
      </div>
    </div>
  </div>

  <!-- Rental Equipment Section -->
  <div class="container-fluid categories-slider text-center">
    <h2>Whatever The Job - We have the Equipment!</h2>

    <div class="row">
      @foreach($categories as $category)
        <div class="card col-lg-3 col-md-4 col-sm-6 col-12">
          <div class="h-100 text-center">
            <a href="/product/category/{{ $category->slug }}">
              <img class="card-img-top " src="/storage/images/{{ $category->image()->value('filename') }}" alt="">
            </a>
            <div class="card-body">
              <h4 class="card-title">
                <a href="/product/category/{{ $category->slug }}">{{ $category->name }}</a>
              </h4>
              <p class="card-text">{{ $category->description }}</p>
            </div>
          </div>
        </div>
      @endforeach

    </div>
  </div>
  <!-- /.row -->

  <!-- Sales Section -->
  <div class="container-fluid bg-secondary page-section">
    <h2 class="text-white">New Equipment and Supplies</h2>

    <div class="row">
      <div class="col-lg-4 col-sm-6 portfolio-item">
        <div class="card h-100 text-center">
          <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
          <div class="card-body">
            <h4 class="card-title">
              <a href="#">STIHL Outdoor Power Equipment</a>
            </h4>
            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur eum quasi sapiente nesciunt? Voluptatibus sit, repellat sequi itaque deserunt, dolores in, nesciunt, illum tempora ex quae? Nihil, dolorem!</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-sm-6 portfolio-item">
        <div class="card h-100">
          <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
          <div class="card-body">
            <h4 class="card-title">
              <a href="#">Grass Seed</a>
            </h4>
            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-sm-6 portfolio-item">
        <div class="card h-100">
          <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
          <div class="card-body">
            <h4 class="card-title">
              <a href="#">OX Tools</a>
            </h4>
            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos quisquam, error quod sed cumque, odio distinctio velit nostrum temporibus necessitatibus et facere atque iure perspiciatis mollitia recusandae vero vel quam!</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-sm-6 portfolio-item">
        <div class="card h-100">
          <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
          <div class="card-body">
            <h4 class="card-title">
              <a href="#">Honda Engines</a>
            </h4>
            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-sm-6 portfolio-item">
        <div class="card h-100">
          <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
          <div class="card-body">
            <h4 class="card-title">
              <a href="#">Bits, Blades, Cleats, Nails, Screws, Staples, Stones & Wheels</a>
            </h4>
            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-sm-6 portfolio-item">
        <div class="card h-100">
          <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
          <div class="card-body">
            <h4 class="card-title">
              <a href="#">Safety Supplies & Personal Protective Equipment</a>
            </h4>
            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque earum nostrum suscipit ducimus nihil provident, perferendis rem illo, voluptate atque, sit eius in voluptates, nemo repellat fugiat excepturi! Nemo, esse.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.row -->

  <!-- Rental Equipment Section -->
  <div class="container-fluid page-section">
    <h2>Services We Offer</h2>

    <div class="row">

      <div class="col-lg-4 col-sm-6 portfolio-item">
        <div class="card h-100">
          <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
          <div class="card-body">
            <h4 class="card-title">
              <a href="#">Chainsaw & Garden Tool Sharpening</a>
            </h4>
            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur eum quasi sapiente nesciunt? Voluptatibus sit, repellat sequi itaque deserunt, dolores in, nesciunt, illum tempora ex quae? Nihil, dolorem!</p>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-sm-6 portfolio-item">
        <div class="card h-100">
          <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
          <div class="card-body">
            <h4 class="card-title">
              <a href="#">Safety Training</a>
            </h4>
            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur eum quasi sapiente nesciunt? Voluptatibus sit, repellat sequi itaque deserunt, dolores in, nesciunt, illum tempora ex quae? Nihil, dolorem!</p>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-sm-6 portfolio-item">
        <div class="card h-100">
          <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
          <div class="card-body">
            <h4 class="card-title">
              <a href="#">Equipment Repair & Maintenance</a>
            </h4>
            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur eum quasi sapiente nesciunt? Voluptatibus sit, repellat sequi itaque deserunt, dolores in, nesciunt, illum tempora ex quae? Nihil, dolorem!</p>
          </div>
        </div>
      </div>

    </div>
  </div>
  <!-- /.row -->


  <!-- Contact Us Section -->
  <div id="contact" class="container-fluid bg-dark text-light page-section">
    <div class="container">
      <h2>Get In Touch With Us</h2>

      <div class="row">
        <div class="col-lg-6">
          <h5><a href="tel:519.485.4231" class="btn btn-block btn-primary font-weight-bold">Call Us: (519) 485-4231</a></h5>
          <p>We're always here to help, and we love hearing from our customers!</p>
          <h5>Email Us:</h5>
          <form method="post" action="/contact">
            @CSRF
            <p>Tell us a bit about yourself</p>
            <div class="form-group row">
              <div class="col-6">
                <input type="text" class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" />
              </div>
              <div class="col-6">
                <input type="text" class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" />
              </div>
            </div>
            <div class="form-group row">
              <div class="col-12">
                <input type="text" class="form-control {{ $errors->has('company') ? 'is-invalid' : '' }}" id="company" name="company" value="{{ old('company') }}" placeholder="Company" />
              </div>
            </div>
            <div class="form-group row">
              <div class="col-12">
                <input type="tel" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Phone" />
              </div>
            </div>
            <div class="form-group row">
              <div class="col-12">
                <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" name="email" value="{{ old('email') }}" placeholder="Email" />
              </div>
            </div>

            <p>Tell us how we can help</p>
            <div class="form-group row">
              <div class="col-12">
                <textarea class="form-control" id="message" name="message" rows="8"></textarea>
              </div>
            </div>

            <div class="row mb-4">
              <div class="col-12">
                <input type="submit" class="btn btn-lg btn-secondary btn-block" value="Send" />
              </div>
            </div>
          </form>
        </div>
        <div class="col-lg-6">
          <h5>Come See Us</h5>
          <p>We are conveniently located in the Heart of Ingersoll</p>
          <address>
            108 Mutual St<br />
            Ingersoll, ON  N5C 1S5<br />
          </address>
          <img class="img-fluid rounded" src="http://placehold.it/700x450" alt="">
        </div>
      </div>
    </div>
  </div>
  <!-- /.row -->

@endsection
