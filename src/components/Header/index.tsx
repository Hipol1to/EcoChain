import React, { useState, useEffect } from "react";
import { ethers } from "ethers"; // Use ethers directly
import { Row, Col, Drawer } from "antd";
import { withTranslation, TFunction } from "react-i18next";
import Container from "../../common/Container";
import { SvgIcon } from "../../common/SvgIcon";
import { Button } from "../../common/Button";
import {
  HeaderSection,
  LogoContainer,
  Burger,
  NotHidden,
  Menu,
  CustomNavLinkSmall,
  Label,
  Outline,
  Span,
  StatusBar,
} from "./styles";

const Header = ({ t }: { t: TFunction }) => {
  const [visible, setVisibility] = useState(false);
  const [isDesktop, setIsDesktop] = useState(window.innerWidth > 768);
  const [balance, setBalance] = useState(null);
  const [ectBalance, setEctBalance] = useState(null);
  const [account, setAccount] = useState(null);

  const dontConnectWallet = async () => {};
  const connectWallet = async () => {
    if (window.ethereum) {
      try {
        // Connect to MetaMask using ethers.js v6 Web3Provider
        const provider = new ethers.BrowserProvider(window.ethereum);
        const accounts = await provider.send("eth_requestAccounts", []);
        setAccount(accounts[0]);

        // Get balance
        const balance = await provider.getBalance(accounts[0]);
        const bnbBalance = ethers.formatEther(balance); // Get balance in BNB
        const conversionRate = 0.0001; // 1 ECT = 0.00010 BNB
        console.log("dwf" + balance);
        console.log("dwf" + bnbBalance);
        console.log("dwf" + conversionRate);

        const ectBalance = ((bnbBalance as any) / conversionRate).toFixed(2); // Convert to ECT and format to 2 decimal places
        setEctBalance(ectBalance);
        console.log("dwf" + ectBalance);
        setBalance(ectBalance); // Set balance in ECT
      } catch (error) {
        console.error("Error connecting to MetaMask:", error);
      }
    } else {
      alert("MetaMask no está instalado.");
    }
  };

  const toggleButton = () => {
    setVisibility(!visible);
  };

  const MenuItem = () => {
    const scrollTo = (id: string) => {
      const element = document.getElementById(id) as HTMLDivElement;
      element.scrollIntoView({
        behavior: "smooth",
      });
      setVisibility(false);
    };
    return (
      <>
        <CustomNavLinkSmall onClick={() => scrollTo("about")}>
          <Span>{t("Sobre nosotros")}</Span>
        </CustomNavLinkSmall>
        <CustomNavLinkSmall onClick={() => scrollTo("mission")}>
          <Span>{t("Casos de uso")}</Span>
        </CustomNavLinkSmall>
        <CustomNavLinkSmall onClick={() => scrollTo("product")}>
          <Span>{t("Compromiso")}</Span>
        </CustomNavLinkSmall>
        <CustomNavLinkSmall
          style={{ width: "180px" }}
          onClick={() => scrollTo("contact")}
        >
          <Span>
            <Button>{t("Contactanos")}</Button>
          </Span>
        </CustomNavLinkSmall>
      </>
    );
  };

  return (
    <HeaderSection>
      {isDesktop && (
        <StatusBar onClick={!account ? connectWallet : connectWallet}>
          {!account ? (
            "Haz click aquí para conectar tu Billetera MetaMask y consultar tus EcoChain Tokens"
          ) : (
            <a style={{ color: "white" }}>
              Tu balance en EcoChain Tokens es de: {ectBalance} ECT
            </a>
          )}
        </StatusBar>
      )}
      {/*
        <StatusBar>
          Haz click aquí para conectar tu Billetera MetaMask y consultar tus
          EcoChain Tokens
        </StatusBar>*/}
      <Container>
        <Row justify="space-between">
          <LogoContainer to="/" aria-label="homepage">
            <SvgIcon src="logo.png" width="281px" height="64px" />
          </LogoContainer>
          <NotHidden>
            <MenuItem />
          </NotHidden>
          <Burger onClick={toggleButton}>
            <Outline />
          </Burger>
        </Row>
        <Drawer closable={false} open={visible} onClose={toggleButton}>
          <Col style={{ marginBottom: "2.5rem" }}>
            <Label onClick={toggleButton}>
              <Col span={12}>
                <Menu>Menu</Menu>
              </Col>
              <Col span={12}>
                <Outline />
              </Col>
            </Label>
          </Col>
          <MenuItem />
        </Drawer>
      </Container>
    </HeaderSection>
  );
};

export default withTranslation()(Header);
