package com.bee.coffee.com;

import com.getcapacitor.BridgeActivity;
import android.os.Bundle;
import android.view.Window;
import android.graphics.Color;

public class MainActivity extends BridgeActivity {
  @Override
  public void onCreate(Bundle savedInstanceState) {
    super.onCreate(savedInstanceState);

    Window window = getWindow();
    window.setNavigationBarColor(Color.parseColor("#2a3c3d"));
  }
}
