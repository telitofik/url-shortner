<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLinkRequest;
use App\Models\Link;
use App\Http\Resources\LinkResource;
use App\Services\LinkService;

use Illuminate\Support\Facades\Gate;


class LinkController extends Controller
{
    public function __construct(private LinkService $service)
    {

    }
    public function index()
    {
        $links = auth()->user()->links()->with('user')->latest()->paginate(10);
        // return LinkResource::collection($links);
        // return response()->json($links);
        return view('links.index',compact('links'));
    }

    public function store(StoreLinkRequest $request)
    {
        $code = $this->service->createShortLink($request->url,auth()->id());
        return back()->with('success',$code);     
    }

    public function redirect($code)
    {
        $link = Link::where('code', $code)->firstOrFail();
        if ($link->expires_at?->isPast()) {
            return back()->with('error','Link expired');
        }
        $link->incrementClicks();
        return redirect($link->url);
    }
    
    public function destroy(Link $link){
        Gate::authorize('delete',$link);
        $link->delete();
        return back()->with('success','Link deleted successfully');
    }
}
