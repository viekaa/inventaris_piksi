<?php
use Illuminate\Http\Request;
use App\Models\User;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;

        $users = User::with('bidang')
            ->where('name', 'like', "%{$q}%")
            ->orWhere('email', 'like', "%{$q}%")
            ->orWhereHas('bidang', function ($query) use ($q) {
                $query->where('nama_bidang', 'like', "%{$q}%");
            })
            ->get();

        return view('search.index', compact('users', 'q'));
    }
}

}
