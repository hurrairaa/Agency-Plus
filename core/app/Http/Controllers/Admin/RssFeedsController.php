<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Language;
use App\RssFeed;
use App\RssPost;
use Illuminate\Support\Facades\Session;

class RssFeedsController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();
        $lang_id = $lang->id;
        $data['lang_id'] = $lang_id;
        $data['rsss'] = RssPost::where('language_id', $lang_id)->orderBy('id', 'DESC')->paginate(10);
        return view('admin.rss.index', $data);
    }

    public function feed(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();
        $lang_id = $lang->id;
        $data['lang_id'] = $lang_id;
        $data['feeds'] = RssFeed::where('language_id', $lang_id)->orderBy('id', 'DESC')->paginate(10);
        return view('admin.rss.feed', $data);
    }

    public function create()
    {
        $data['langs'] = Language::all();
        return view('admin.rss.create', $data);
    }

    public function store(Request $request)
    {
        $data  = new RssFeed();
        $input = $request->all();
        $data->fill($input)->save();

        $lastRecord = RssFeed::orderBy('id', 'desc')->first();
        $feed = \Feeds::make($lastRecord->feed_url);

        $items = $feed->get_items(); //grab all items inside the rss
        $i = 0;
        foreach ($items as $item) :
            if ($i == $lastRecord->post_limit) {
                break;
            }
            $title =  $item->get_title();
            if ($title) {
                $titleCheck = RssPost::where('title', $title)->get();
                $totaltitle =  count($titleCheck);
                if ($totaltitle == 0) {
                    $post = new RssPost();
                    $post->language_id  = $lastRecord->language_id;
                    $post->rss_feed_id  = $lastRecord->id;
                    $post->title        = $title;
                    $post->slug         = slug_create($title);
                    $post->description  = $item->get_description();

                    if ($enclosure = $item->get_enclosure(0)) {

                        $type = $enclosure->get_real_type();
                        // Is it a Image?
                        if (stristr($type, 'image/')) {
                            if (empty($enclosure)) {
                                $post->rss_image = '';
                            }
                            $post->photo = $enclosure->get_link();
                        }
                    }
                    $post->rss_link = $item->get_permalink();
                    $post->save();
                }
            }
            $i++;
        endforeach;

        Session::flash('success', 'Rss Added successfully!');
        return "success";
    }

    public function feedUpdate($id)
    {
        $lastRecord = RssFeed::findOrFail($id);
        $feed = \Feeds::make($lastRecord->feed_url);

        $items = $feed->get_items(); //grab all items inside the rss
        $i = 0;
        foreach ($items as $item) :
            if ($i == $lastRecord->post_limit) {
                break;
            }
            $title =  $item->get_title();
            if ($title) {
                $titleCheck = RssPost::where('title', $title)->get();
                $totaltitle =  count($titleCheck);
                if ($totaltitle == 0) {
                    $post = new RssPost();
                    $post->language_id  = $lastRecord->language_id;
                    $post->rss_feed_id  = $lastRecord->id;
                    $post->title        = $title;
                    $post->slug         = slug_create($title);
                    $post->description  = $item->get_description();

                    if ($enclosure = $item->get_enclosure(0)) {

                        $type = $enclosure->get_real_type();
                        // Is it a Image?
                        if (stristr($type, 'image/')) {
                            if (empty($enclosure)) {
                                $post->rss_image = '';
                            }
                            $post->photo = $enclosure->get_link();
                        }
                    }
                    $post->rss_link = $item->get_permalink();
                    $post->save();
                }
            }
            $i++;
        endforeach;

        Session::flash('success', 'Rss Updated successfully!');
        return redirect()->back();
    }

    public function edit($id)
    {
        $data['rss'] = RssFeed::findOrFail($id);
        $data['langs'] = Language::all();
        return view('admin.rss.edit', $data);
    }

    public function update(Request $request)
    {
        $data  = RssFeed::find($request->id);
        $input = $request->all();
        $data->update($input);
        Session::flash('success', 'Feed updated successfully!');
        return "success";
    }

    public function rssdelete(Request $request)
    {
        $feed_posts = RssFeed::find($request->id)->rss;
        if (!empty($feed_posts)) {
            foreach ($feed_posts as $feed) {
                $feed->delete();
            }
        }
        $feed_posts = RssFeed::find($request->id)->delete();
        Session::flash('success', 'Rss Feed deleted successfully!');
        return back();
    }

    public function delete(Request $request)
    {
        $rss = RssPost::findOrFail($request->id);
        $rss->delete();
        Session::flash('success', 'Rss Post deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {

        $ids = $request->ids;

        foreach ($ids as $id) {
            $rss = RssPost::findOrFail($id);
            $rss->delete();
        }

        Session::flash('success', 'RSS posts deleted successfully!');
        return "success";
    }
}
