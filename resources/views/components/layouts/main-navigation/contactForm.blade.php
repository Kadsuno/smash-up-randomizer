<x-layouts.main>
    <div id="hero-header">
        <div class="position-relative w-100 overflow-hidden">
            <div class="bg-options" id="hero-js" style="background-image: linear-gradient(rgba(0,0,0,0.25), rgba(0,0,0,0.25)), url('{{ asset('images/contact_2.png') }}')">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 pt-5">
                            <div class="my-5 mx-5 text-white bg-transparent">
                                <div class="px-3 py-3">
                                    <h1 class="mb-3">
                                        Contact Us
                                    </h1>
                                    <p>
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
    <div class="container-fluid mt-5">
        <div class="row mx-5">
            <div class="col-md">
                <h2>
                    Contact Form
                </h2>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row mx-5 px-5">
            @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
            @endif
            <form method="POST" action="{{ route('contact.us.store') }}" id="contactUSForm">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <strong>Name:</strong>
                            <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <strong>Email:</strong>
                            <input type="text" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <strong>Phone:</strong>
                            <input type="text" name="phone" class="form-control" placeholder="Phone" value="{{ old('phone') }}">
                            @if ($errors->has('phone'))
                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <strong>Subject:</strong>
                            <input type="text" name="subject" class="form-control" placeholder="Subject" value="{{ old('subject') }}">
                            @if ($errors->has('subject'))
                            <span class="text-danger">{{ $errors->first('subject') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <strong>Message:</strong>
                            <textarea name="message" rows="3" placeholder="What is on your mind?" class="form-control">{{ old('message') }}</textarea>
                            @if ($errors->has('message'))
                            <span class="text-danger">{{ $errors->first('message') }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button class="btn btn-success btn-submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.main>