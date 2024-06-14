<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Index View</title>
</head>
<body>
    <h1>Book List:</h1>
    <table>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        @foreach($records as $record)
           <tr>
            <td>{{$record->id}}</td>
            <td>{{$record->book_name}}</td>
            <td>{{$record->book_price}}</td>
            <td>
                <form action="/orders" method="post">
                    @csrf 
                    <input type="hidden" name="book_id" value="{{$record->id}}">
                    <input type="submit" value="Buy Now">
                </form>
            </td>
           </tr>
        @endforeach
    </table>
</body>
</html>