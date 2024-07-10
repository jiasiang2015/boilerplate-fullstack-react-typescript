import { useCallback, useEffect, useState } from "react";
import liff from '@line/liff';

import { UserApi, UserInfoDTO } from "@/app-client/api";
import { ENV } from "@/global/const";

export function useLiffLogin() {
  const [userInfo, setUserInfo] = useState<UserInfoDTO | null>(null);
  const [isLiffMounted, setIsLiffMounted] = useState<boolean>(false);

  const liffLogin = useCallback(async () => {
    try {
      await liff.init({ liffId: ENV.LIFF_ID });
    } catch (err) {
      console.error('init liff failed');
    }

    // 檢查是否已經登陸 line liff
    if (!liff.isLoggedIn()) {
      liff.login({ redirectUri: window.location.href });
      return;
    }

    // 使用 liff 的資料並且存入我們自己的後端
    try {
      const accessToken = liff.getAccessToken();
      // 檢查 Access Token
      if (!accessToken) throw Error('Access Token is empty!');
      const [profile, friend] = await Promise.all([liff.getProfile(), liff.getFriendship()]);
      await UserApi.lineRegistrationAndLogin(accessToken, profile);

      const userReslut = (await UserApi.me()).data;
      setUserInfo(userReslut.data);
      setIsLiffMounted(true);
    } catch (err) {
      console.error('get profile or friend failed', err);
    }
  }, []);

  /** Mocked 登入 */
  const normalLogin = useCallback(async () => {
    await UserApi.lineRegistrationAndLogin("mocked-accessToken", {
      userId: "Bill-line-uid",
      displayName: 'Bill',
      pictureUrl: 'https://example.com.tw/image1.jpg',
    });
    const userReslut = (await UserApi.me()).data;
    setUserInfo(userReslut.data);
    setIsLiffMounted(true);
  }, []);

  useEffect(() => {
    if (ENV.LIFF_LOGIN_MOCK_ENABLE) {
      normalLogin();
    }
    else {
      liffLogin();
    }
  }, []);

  return { userInfo, isLiffMounted };
}

/** Liff 分享 Hooks */
export function useLiffShare() { 

  /** 送出 Flex Message 的 Event 邀請
   *  @returns [true = 'success'] | [false = 'failed'] */
  const shareFlexMessage = useCallback(async (content: string) => {

    // 如果有開 Mock 就複製到剪貼簿，或者沒有登入也複製
    if (ENV.LIFF_LOGIN_MOCK_ENABLE || !liff.isLoggedIn()) {
      alert('Login mock disable');
      return true;
    }

    // 判斷 Liff 有沒有開啟這個功能 (如果沒有要自己去 Line Develop console 裡打開)
    if (liff.isApiAvailable('shareTargetPicker') === false) {
      console.error('Not support share picker');
      return false;
    }
    // Basic Data (Line 的 type 很廢，取不出正確的 type)
    let contentJson: any = {};
    try {
      contentJson = JSON.parse(content);
    }
    catch (error) {
      alert('Flex Message Content is not JSON format');
    }

    // 送出 Flex Message
    try {
      const liffResponse = await liff.shareTargetPicker([
        {
          type: 'flex',
          altText: 'Shared A Flex Message',
          contents: contentJson,
        }
      ]);
      if (liffResponse) {
        // succeeded in sending a message through TargetPicker
        console.log(`[${liffResponse.status}] Message sent!`);
        return true;
      }
      else {
        const [majorVer, minorVer] = (liff.getLineVersion() || "").split('.');
        if (parseInt(majorVer) == 10 && parseInt(minorVer) < 11) {
          alert('TargetPicker was opened at least. Whether succeeded to send message is unclear')
        } else {
          console.log('TargetPicker was closed!')
        }
        return false;
      }
    } catch (error) {
      // something went wrong before sending a message
      console.log('something wrong happen');
      console.error(error);
      return false;
    }
  }, []);

  return { shareFlexMessage };
}

export function useLiffOpenWindow() {
  const openWindow = useCallback((url: string) => {
    try {
      if (liff.isApiAvailable('openWindow')) {
        liff.openWindow({ url, external: true });
      }
    }
    catch (error) {
      console.log('open Liff Window Error:', error);
      console.log('use normal window open');
      window.open(url);
    }
  }, []);
  return { openWindow };
}