<?php

namespace App\Livewire\Iptv\Channels\Tools;

use App\Models\Channel;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\AnalyzeStream;
use App\Actions\Tools\AnalyzeStreamAction;
use App\Traits\Livewire\NotificationTrait;
use App\Traits\Channels\GetAllChannelStreamsTrait;

class StreamAnalyzeComponent extends Component
{
    use GetAllChannelStreamsTrait, NotificationTrait;

    public Channel $channel;

    public array $streams = [];
    public array $analyzedStreams = [];

    public $analyzed;
    public bool $analyzedModal = false;

    public function mount() {}

    #[On('refresh_analyzed_streams')]
    public function getAnalyzedStreams()
    {
        foreach ($this->streams as $stream) {
            if (!str_contains($stream, ":1234")) {
                $stream = $stream . ":1234";
            }
            if (AnalyzeStream::where('stream_url', $stream)->first()) {
                foreach (AnalyzeStream::where('stream_url', $stream)->orderBy('created_at', 'desc')->take(5)->get()->toArray() as $analyzed) {
                    array_push($this->analyzedStreams, $analyzed);
                }
            }
        }
    }

    public function analyze($stream)
    {
        $response = (new AnalyzeStreamAction($stream))();
        if (blank($response)) {
            return $this->error_alert("Nepodařilo se provést analýzu");
        }
        $this->dispatch('refresh_analyzed_streams');
        $this->openAnalyzeModal(json_encode($response));
        return $this->success_alert("Analýza vytvořena");
    }

    public function openAnalyzeModal($analyzeStream)
    {
        $this->analyzed = json_decode($analyzeStream, true);
        return $this->analyzedModal = true;
    }

    public function closeModal()
    {
        return $this->analyzedModal = false;
    }

    #[On('refresh_analyzed_streams')]
    public function render()
    {
        $this->streams = $this->getStreams($this->channel);
        $this->getAnalyzedStreams();
        return view('livewire.iptv.channels.tools.stream-analyze-component', [
            'headers' => [
                ['key' => 'stream_url', 'label' => 'Stream', 'class' => 'text-white/80'],
                ['key' => 'created_at', 'label' => 'Vytvořeno', 'class' => 'text-white/80'],
                // ['key' => 'status', 'label' => 'Status', 'class' => 'text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'text-white/80'],
            ]
        ]);
    }
}
