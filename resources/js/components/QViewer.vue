<template>
  <div>
    <heading class="mb-6">创建题目</heading>
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
      <!-- <h3 class="test">创建题目</h3> -->
      <form>
        <div class="form-group">
          <label for="json">题目数据(Json)</label>
          <textarea class="form-control" id="json" rows="15" placeholder="请输入数据" v-model="json"></textarea>
          <label for="json">题干(支持换行)</label>
          <textarea class="form-control" rows="3" placeholder="请输入题干" v-model="description"></textarea>
        </div>
        <div class="form-group">
          <div :class="'alert alert-' + alertStatus" role="alert">
            <span>状态：</span>
            <span class="status">{{ status }}</span>
          </div>
        </div>
        <div class="form-group upload-control">
          <div class="custom-file">
            <input
              type="file"
              class="custom-file-input"
              name="video"
              id="video"
              accept="video/mp4"
              :disabled="videoUpload || disableUpload"
              @change="uploadQuestionVideoFile($event)"
            />
            <label class="custom-file-label custom-video-file-label" for="video">
              {{
              videoFile != null
              ? videoFile.name
              : "待选择视频"
              }}
            </label>
          </div>
          <div class="alert alert-success" role="alert" v-if="video">
            上传成功,视频链接：
            <span>
              <a :href="video.url">{{ video.url }}</a>
            </span>
          </div>
          <div class="progress" v-if="videoUpload">
            <div
              class="progress-bar"
              role="progressbar"
              :style="'width:' + uploadProgressValue + '%'"
              :aria-valuenow="uploadProgressValue"
              aria-valuemin="0"
              aria-valuemax="100"
            >{{ uploadProgressValue + "%" }}</div>
          </div>
        </div>

        <!-- 音频上传 -->
        <div class="form-group upload-control">
          <div class="custom-file">
            <input
              type="file"
              class="custom-file-input"
              name="audio"
              id="audio"
              accept="audio/mp3"
              :disabled="audioUpload"
              @change="uploadAudio($event)"
            />
            <label class="custom-file-label custom-audio-file-label" for="audio">
              {{
              audioFile != null
              ? audioFile.name
              : "待选择音频"
              }}
            </label>
          </div>
          <div class="alert alert-success" role="alert" v-if="audio">
            上传成功,音频链接：
            <span>
              <a :href="audio.url">{{ audio.url }}</a>
            </span>
          </div>
          <div class="progress" v-if="audioUpload">
            <div
              class="progress-bar"
              role="progressbar"
              :style="'width:' + audioUploadProgressValue + '%'"
              :aria-valuenow="audioUploadProgressValue"
              aria-valuemin="0"
              aria-valuemax="100"
            >{{ audioUploadProgressValue + "%" }}</div>
          </div>
        </div>

        <form class="form-group">
          <div
            class="alert alert-success"
            role="alert"
            v-if="explanation"
          >提交成功,解析ID：{{ explanation.id }}</div>
        </form>

        <div class="form-group upload-control">
          <div
            :class="
                            pick
                                ? 'form-group  question-explain show-explain'
                                : 'hide-explain'
                        "
          >
            <div class="form-group">
              <label for="explain-json">解析内容</label>
              <textarea
                class="form-control"
                id="explanationContent"
                rows="10"
                placeholder="请输入解析内容"
                v-model="explanationContent"
              ></textarea>
            </div>
            <div class="explain-bottom">
              <button
                class="btn btn-primary btn-lg submit-explain"
                type="button"
                :disabled="!explainCanSubmit"
                @click="submitExplanation"
              >提交解析</button>
            </div>
          </div>
        </div>

        <div class="form-group bottom">
          <label class="checkbox-inline">
            <input type="checkbox" id="inlineCheckbox1" value="true" v-model="showExplain" />
            添加解析
          </label>
          <button
            type="button"
            class="btn btn-primary btn-lg submit-btn"
            :disabled="!canSubmit"
            @click="submitQuestion"
          >提交</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    this.getUserToken(config.userId);
  },

  data() {
    return {
      json: "",
      explanationContent: "",
      status: "待输入",
      uploadProgressValue: 0,
      audioUploadProgressValue: 0,
      videoFile: null,
      explanationVideoFile: null,
      video: null,
      audio: null,
      canSubmit: false,
      explainCanSubmit: false,
      explaninSubmied: false,
      api: "/nova-vendor/question-viewer",
      explanationApi: "/nova-vendor/question-viewer/submit-explanation",
      alertStatus: "info",
      videoUpload: false,
      audioUpload: false,
      api_token: "",
      showExplain: [],
      pick: false,
      explanation: null,
      description: "",
      audioFile: null,
      disableUpload: false
    };
  },

  watch: {
    json: function() {
      if (this.json == "") {
        this.alertStatus = "info";
        return (this.status = "待输入");
      }

      if (!this.isJsonString(this.json)) {
        this.alertStatus = "danger";
        return (this.status = "数据格式错误");
      }
      this.alertStatus = "success";
      this.status = "可提交";

      this.canSubmit = true;
    },
    explanationContent: function() {
      this.explainCanSubmit =
        this.explanationContent.length >= 10 && !this.explaninSubmied;
    },
    showExplain: function() {
      this.pick = this.showExplain[0];
      this.canSubmit = false;
    }
  },

  methods: {
    uploadQuestionVideoFile: function(e) {
      var _this = this;
      _this.canSubmit = false;
      _this.videoFile = e.target.files[0];
      _this.audioUpload = true;
      _this.disableUpload = true;
      let formData = new FormData();
      formData.append("video", _this.videoFile);

      let token = this.api_token;
      if (token == null) {
        return _this.$toasted.show("身份获取失败,请刷新后再试!", {
          type: "error"
        });
      }

      var videoUploadApi =
        "http://upload.datizhuanqian.com/api/video/upload?api_token=" + token;
      Nova.request()
        .post(videoUploadApi, formData, {
          onUploadProgress: function(progressEvent) {
            _this.uploadProgressValue = Math.round(
              (progressEvent.loaded * 100) / progressEvent.total
            );
          }
        })
        .then(response => {
          _this.video = response.data;
          if (_this.json != "") {
            _this.canSubmit = true;
          }
        });
    },

    uploadAudio: function(e) {
      var _this = this;
      _this.canSubmit = false;
      _this.audioFile = e.target.files[0];
      _this.audioUpload = true;
      _this.disableUpload = true;

      let token = this.api_token;
      if (token == null) {
        return _this.$toasted.show("身份获取失败,请刷新后再试!", {
          type: "error"
        });
      }

      let formData = new FormData();
      formData.append("audio", _this.audioFile);
      formData.append("api_token", token);

      var audioUploadApi = "http://upload.datizhuanqian.com/api/audio";
      Nova.request()
        .post(audioUploadApi, formData, {
          onUploadProgress: function(progressEvent) {
            _this.audioUploadProgressValue = Math.round(
              (progressEvent.loaded * 100) / progressEvent.total
            );
          }
        })
        .then(response => {
          _this.audio = response.data.data;
          console.log(_this.audio);
          if (_this.json != "") {
            _this.canSubmit = true;
          }
        });
    },

    submitQuestion: function() {
      var _this = this;
      var json = JSON.parse(this.json);
      if (this.video != null) {
        json.video_id = _this.video.id;
      }

      if (this.audio != null) {
        json.audio_id = _this.audio.id;
      }

      //解析
      if (this.explanation != null) {
        json.explanation_id = this.explanation.id;
      }

      //支持换行
      if (this.description != "") {
        json.description = this.description;
      }

      Nova.request()
        .post(this.api, {
          json
        })
        .then(response => {
          let data = response.data;
          console.log(data);
          if (data.code == 200) {
            var text = "发表成功,题目ID:" + data.data.id;
            _this.$toasted.show(text, { type: "success" });
            setTimeout(function() {
              location.reload();
            }, 500);
          }
        });
      // _this.canSubmit = false;
    },

    isJsonString: function(str) {
      try {
        if (typeof JSON.parse(str) == "object") {
          return true;
        }
      } catch (e) {}
      return false;
    },

    getUserToken: function(id) {
      var _this = this;
      var userInfoApi = "/api/nova/users/" + id;

      Nova.request()
        .get(userInfoApi)
        .then(response => {
          return (_this.api_token = response.data);
        });
      return _this.api_token;
    },

    submitExplanation: function() {
      var _this = this;

      var explanation = {
        content: _this.explanationContent
      };

      Nova.request()
        .post(_this.explanationApi, {
          explanation
        })
        .then(response => {
          var data = response.data;
          _this.explainCanSubmit = false;
          _this.explaninSubmied = true;
          if (data.code == 200) {
            var text = "解析发表成功,解析ID:" + data.data.id;
            _this.$toasted.show(text, { type: "success" });
          }
          _this.explanation = data.data;
          _this.pick = false;
        });
    }
  }
};
</script>

<style scoped src="../../../../../public/css/app.css"></style>
<style>
.status {
  font-weight: bold;
}

.upload-control > div {
  margin-bottom: 1rem !important;
}

.custom-file-label::after {
  content: "选择文件" !important;
}

.custom-video-file-label::after {
  content: "选择视频" !important;
}

.custom-audio-file-label::after {
  content: "选择音频" !important;
}

.custom-file-explain {
  position: relative;
  display: inline-block;
  width: 85%;
  height: calc(1.6em + 0.75rem + 2px);
}

.explain-bottom {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
}

.submit-explain {
  height: calc(1.6em + 0.75rem + 2px);
}

.hide-explain {
  display: none;
}

.bottom {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
}

.submit-btn {
  width: 90%;
}

textarea {
  margin-bottom: 10px !important;
}
</style>
