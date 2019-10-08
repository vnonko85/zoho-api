<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <a href="{{ $getCodeUrl }}">Get token</a>
                    <form method="POST" action="{{ route('deal.create') }}">
                        @csrf()
                        <div class="form-group">
                            <label for="inputDealName">Deal name</label>
                            <input type="text" name="Deal_Name" class="form-control" id="inputDealName" placeholder="Enter Deal name">
                            @if ($errors->has('Deal_Name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('Deal_Name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputOSDI">Overall Sales Duration ID</label>
                            <input type="text" name="Overall_Sales_Duration" class="form-control" id="inputOSDI" placeholder="Enter overall sales duration ID">
                            @if ($errors->has('Overall_Sales_Duration'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('Overall_Sales_Duration') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputSCDI">Sales Cycle Duration ID</label>
                            <input type="text" name="Sales_Cycle_Duration" class="form-control" id="inputSCDI" placeholder="Enter Sales Cycle Duration ID">
                            @if ($errors->has('Sales_Cycle_Duration'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('Sales_Cycle_Duration') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputStage">Stage</label>
                            <input type="text" name="Stage" class="form-control" id="inputStage" placeholder="Enter Stage">
                            @if ($errors->has('Stage'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('Stage') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputClosingDate">Closing date</label>
                            <input type="text" name="Closing_Date" class="form-control" id="inputClosingDate" placeholder="Format: YYYY-mm-dd">
                            @if ($errors->has('Closing_Date'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('Closing_Date') }}</strong>
                                </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Create Deal</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('task.create') }}" method="POST">
                        @csrf()
                        <div class="form-group">
                            <label for="inputSubject">Subject</label>
                            <input type="text" name="Subject" class="form-control" id="inputSubject" placeholder="Enter subject">
                            @if ($errors->has('Subject'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('Subject') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputWhatId">Deal Id</label>
                            <input type="text" name="What_Id" class="form-control" id="inputWhatId" placeholder="Enter Deal ID">
                            @if ($errors->has('What_Id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('What_Id') }}</strong>
                                </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Create task</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
