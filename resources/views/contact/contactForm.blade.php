<x-layouts.main>
    <div id="hero-header" class="animate__animated animate__fadeIn">
        <div class="position-relative w-100 overflow-hidden">
            <div class="bg-options" id="hero-js" style="background-image: url('{{ asset('images/contact_2.png') }}'); background-attachment: fixed; background-position: center; background-size: cover;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 pt-5">
                            <div class="my-5 text-white bg-black bg-opacity-75 rounded-3 px-5 py-5 animate__animated animate__slideInLeft">
                                <div class="px-3 py-3">
                                    <h1 class="mb-3 display-4 fw-bold">
                                        Contact Us
                                    </h1>
                                    <p class="lead">
                                        Do you have a question, want to find out more about Smash Up Randomizer or just want to say hello? Then you've come to the right place! We are always open to inquiries, feedback or exciting stories about our shared hobby. Simply fill out the contact form or send us an e-mail. We look forward to hearing from you. We'll get back to you faster than you can shuffle cards!
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md">
                <h2 class="text-center mb-4 animate__animated animate__fadeInDown">
                    Contact Form
                </h2>
            </div>
        </div>
    </div>
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            @if (Session::has('success'))
            <div class="alert alert-success animate__animated animate__fadeIn">
                {{ Session::get('success') }}
            </div>
            @endif
            <div class="col-md-8">
                <form method="POST" action="{{ route('contact.us.store') }}" id="contactUSForm" class="bg-dark p-4 rounded-3 shadow-lg animate__animated animate__fadeInUp">
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Your Name" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Your Email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone:</label>
                                <input type="tel" name="phone" id="phone" class="form-control" placeholder="Your Phone" value="{{ old('phone') }}">
                                @if ($errors->has('phone'))
                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="subject" class="form-label">Subject:</label>
                                <input type="text" name="subject" id="subject" class="form-control" placeholder="Message Subject" value="{{ old('subject') }}">
                                @if ($errors->has('subject'))
                                <span class="text-danger">{{ $errors->first('subject') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="message" class="form-label">Message:</label>
                                <textarea name="message" id="message" rows="5" placeholder="What is on your mind?" class="form-control">{{ old('message') }}</textarea>
                                @if ($errors->has('message'))
                                <span class="text-danger">{{ $errors->first('message') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <button class="btn btn-primary btn-lg btn-submit animate__animated animate__pulse animate__infinite">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.main>

<style>
    .animate__animated {
        animation-duration: 1s;
    }
    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }
    .btn-submit {
        transition: all 0.3s ease;
    }
    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const form = document.getElementById('contactUSForm');
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            // Here you can add form validation or AJAX submission
            form.submit();
        });
    });
</script>