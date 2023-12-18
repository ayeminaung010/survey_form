<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body class="antialiased">

    <div class="container ">
        {{-- show alert from session --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- show alert for error  --}}
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="row my-5">
            <div class="col-6">
                <form action="{{ route('create_survey') }}" method="POST">
                    @csrf
                    <div class="my-2">
                        <label for="">Survey Name</label>
                        <input type="text" class=" form-control" name="survey_name" placeholder="Enter Survey Name">

                        @error('survey_name')
                            <small class=" text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="">Start Date</label>
                        <input type="date" class=" form-control" name="start_date" placeholder="">
                        @error('start_date')
                            <small class=" text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="">End Date</label>
                        <input type="date" class=" form-control" name="end_date" placeholder="">
                        @error('end_date')
                            <small class=" text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="">Question 1</label>
                        <input type="text" class="form-control" name="title[]" placeholder="Enter Question Title"
                            value="Name" readonly>
                        <select name="type[]" class=" form-control" id="">
                            <option value="">choose form type</option>
                            <option value="text">Text</option>
                            <option value="number">Number</option>
                            <option value="textarea">Textarea</option>
                            <option value="select">Selection</option>
                        </select>
                    </div>

                    <div class="my-2">
                        <label for="">Question 2</label>
                        <input type="text" class="form-control" name="title[]" placeholder="Enter Question Title"
                            value="Phone" readonly>
                        <select name="type[]" class=" form-control" id="">
                            <option value="">choose form type</option>
                            <option value="text">Text</option>
                            <option value="number">Number</option>
                            <option value="textarea">Textarea</option>
                            <option value="select">Selection</option>
                        </select>
                    </div>

                    <div class="my-2">
                        <div class="sampleBox my-2 ">
                            <div class="">
                                <label for="">Question</label>
                                <input type="text" class="form-control" name="title[]"
                                    placeholder="Enter Question Title">
                                <select name="type[]" class=" form-control" id="">
                                    <option value="" disabled selected>choose form type</option>
                                    <option value="text">Text</option>
                                    <option value="number">Number</option>
                                    <option value="textarea">Textarea</option>
                                    <option value="select">Selection</option>
                                </select>
                            </div>
                            <div class="text-end">
                                <button type="button" class=" btn btn-danger removeBtn  mt-2 ">Remove</button>
                            </div>
                        </div>
                        <div class="addMoreQuestionContainer">

                        </div>
                        <button class=" btn btn-info mt-2" type="button" id="addQuestion">Add New Question</button>
                    </div>

                    <div class="">
                        <button class="btn btn-primary " type="submit">Save & Generate Link</button>
                    </div>
                </form>
            </div>
            <div class="col-6">
                <h4>Survey List</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Survey Name</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Total Responses</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($surveys as $key=> $survey)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $survey->name }}</td>
                            <td>{{ $survey->start_date }}</td>
                            <td>{{ $survey->end_date }}</td>
                            <td>{{ $survey->total_responses }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $("document").ready(function() {
            $("#addQuestion").click(function() {
                $('.addMoreQuestionContainer').append(
                    `
                        <div class="sampleBox my-2 " >
                            <div class="">
                                <label for="">Question</label>
                                <input type="text" class="form-control" name="title[]" placeholder="Enter Question Title" >
                                <select name="type[]" class=" form-control"  id="">
                                    <option value="" >choose form type</option>
                                    <option value="text" disabled selected>Text</option>
                                    <option value="number">Number</option>
                                    <option value="textarea">Textarea</option>
                                    <option value="select">Selection</option>
                                </select>
                            </div>
                            <div class="text-end">
                                <button type="button" id="" class=" btn btn-danger removeBtn mt-2 ">Remove</button>
                            </div>
                        </div>
                        `
                );
            })

            // Use event delegation for dynamically added elements
            $(".addMoreQuestionContainer").on("click", ".removeBtn", function() {
                $(this).closest(".sampleBox").remove();
            });
        })
    </script>
</body>

</html>
